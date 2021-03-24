<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    private $productModel;
    private $categoryModel;

    public function __construct(Product $productModel, ProductCategory $categoryModel)
    {
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    public function index()
    {

        $products = $this->productModel->where('type', 0)->paginate(25);

        return view('inventory.products.index', compact('products'));
    }

    public function create()
    {

        $categories = $this->categoryModel->pluck('name', 'id');

        return view('inventory.products.create', compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $request->merge(['type' => '0', 'branch_id' => session('dBranch')]);

        $this->productModel->create($request->all());

        return redirect()->route('products.index')->withStatus('Producto agregado correctamente.');
    }

    public function show(Product $product)
    {

        $solds = $product->solds()->latest()->limit(25)->get();

        $receiveds = $product->receiveds()->latest()->limit(25)->get();
        return view('inventory.products.show', compact('product', 'solds', 'receiveds'));
    }

    public function edit(Product $product)
    {
        // dd($product);

        $categories = $this->categoryModel->pluck('name', 'id');

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $request->merge(['type' => '0']);

        $product->update($request->except('unity'));

        return redirect()->route('products.index')->withStatus('Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if ($product->solds()->count()) {

            return redirect()->route('products.index')->withStatus('NO ES POSIBLE ELIMINAR EL PRODUCTO, YA POSEE VENTAS.');
        }
        if ($product->receiveds()->count()) {

            return redirect()->route('products.index')->withStatus('NO ES POSIBLE ELIMINAR EL PRODUCTO, YA POSEE COMPRAS.');
        }
        if ($product->materials()->count()) {

            return redirect()->route('products.index')->withStatus('NO ES POSIBLE ELIMINAR EL PRODUCTO, ESTA RELACIONADO CON MATERIA PRIMA.');
        }
        $product->delete();

        return redirect()->route('products.index')->withStatus('Producto eliminado correctamente.');
    }



    public function tableProducts($id)
    {
        $products = $this->productModel->select('id', 'type', 'name')->where('type', 0)->get()->pluck('name', 'id');
        $view = view('sales._products', ['key' => $id, 'products' => $products])->render();

        return response()->json(['html' => $view], 200);
    }
}
