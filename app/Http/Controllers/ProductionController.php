<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductCategory;
use App\ProductMaterial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{

    private $productModel;
    private $categoryModel;
    private $materialsModel;

    public function __construct(Product $productModel, ProductCategory $categoryModel, ProductMaterial $materialsModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
        $this->materialsModel = $materialsModel;
    }

    public function index()
    {

        $products = $this->productModel->where('type', 2)->paginate(25);

        return view('inventory.production.index', compact('products'));
    }

    public function create()
    {

        $categories = $this->categoryModel->pluck('name', 'id');
        $materials = $this->productModel->select('id', 'type', 'name', 'price', 'stock', 'unity')->where('type', 1)->get();

        return view('inventory.production.create', compact('categories', 'materials'));
    }

    public function store(ProductRequest $request)
    {

        $input = $request->all();
        $materials = [];
        if (isset($input['materials'])) {
            $materials = $input['materials'];
            unset($input['materials']);
        }

        $product = $this->productModel->create($input);
        $product->materials()->createMany($materials);

        return redirect()->route('production.index')->withStatus('Producción agregado correctamente.');
    }

    public function show(Product $production)
    {

        $solds = $production->solds()->latest()->limit(25)->get();

        $receiveds = $production->receiveds()->latest()->limit(25)->get();

        return view('inventory.production.show', compact('production', 'solds', 'receiveds'));
    }

    public function edit(Product $production)
    {

        $production->load('materials.material');
        $materials = $this->productModel->select('id', 'type', 'name', 'price', 'stock', 'unity')->where('type', 1)->get();
        $categories = $this->categoryModel->pluck('name', 'id');

        return view('inventory.production.edit', compact('production', 'categories', 'materials'));
    }

    public function update(ProductRequest $request, Product $production)
    {

        $input = $request->all();
        $materials = [];
        if (isset($input['materials'])) {
            $materials = $input['materials'];
            unset($input['materials']);
        }

        $production->update($input);

        foreach ($materials as $mat) {
            if ($mat['id'] == 'new') {
                $production->materials()->create($mat);
            } else {
                $this->materialsModel->find($mat['id'])->update($mat);
            }
        }

        return redirect()->route('production.index')->withStatus('Producción actualizado correctamente.');
    }

    public function destroy(Product $production)
    {

        // $production->delete();

        return redirect()->route('production.index')->withStatus('Producción eliminado correctamente.');
    }

    public function tableMaterials($id)
    {
        $materials = $this->productModel->select('id', 'type', 'name')->where('type', 1)->get()->pluck('name', 'id');
        $view = view('inventory.production._materials', ['key' => $id, 'materials' => $materials])->render();

        return response()->json(['html' => $view], 200);
    }

    public function deleteMaterials($id)
    {

        $this->materialsModel->find($id)->delete();

        return response()->json(null, 200);
    }

    public function producir(Product $production)
    {

        $production->load('materials.material');

        return view('inventory.production.producir', compact('production'));
    }

    public function make(Request $request, Product $production)
    {

        $input = $request->all();
        if ($input['ferror']) {
            return redirect()->back();
        } else {

            try {
                DB::beginTransaction();



                $production->load('materials.material');
                foreach ($production->materials as $mat) {
                    $qty = $mat->quantity * $input['stock'];
                    if ($qty > $mat->material->stock) {

                        return redirect()->back()->withErrors('Ingrediente: ' . $mat->material->name . ' Cant: ' . $qty . ' es mayor al stock (' . $mat->material->stock . ')');
                    }
                    $data = [
                        'stock' => $mat->material->stock - $qty,
                        'reserved_stock' => $mat->material->reserved_stock + $qty,
                    ];

                    $mat->material->update($data);
                }

                $production->update([
                    'stock' => $production->stock + $input['stock'],
                ]);

                DB::commit();
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage(), 500);
            }
        }

        return redirect()->route('production.index')->withStatus('Producción realizada correctamente.');
    }

    public function inproducir(Product $production)
    {

        $production->load('materials.material');

        return view('inventory.production.inproducir', compact('production'));
    }

    public function inmake(Request $request, Product $production)
    {

        $input = $request->all();

        $diff = $production->stock - $input['stock'];
        $production->update([
            'stock' => $input['stock'],
        ]);

        $production->load('materials.material');
        foreach ($production->materials as $mat) {
            $qty = $mat->quantity * $diff;
            $data = [
                'stock' => $mat->material->stock + $qty,
                'reserved_stock' => $mat->material->reserved_stock - $qty,
            ];

            $mat->material->update($data);
        }

        return redirect()->route('production.index')->withStatus('Desproducción realizada correctamente.');
    }
}
