<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;

class MaterialController extends Controller{

    private $productModel;
    private $categoryModel;

    public function __construct(Product $productModel, ProductCategory $categoryModel){
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    public function index(){

        $products = $this->productModel->where('type', 1)->paginate(25);

        return view('inventory.materials.index', compact('products'));
    }

    public function create(){

        $categories = $this->categoryModel->pluck('name','id');

        return view('inventory.materials.create', compact('categories'));
    }

    public function store(ProductRequest $request){

        $this->productModel->create($request->all());

        return redirect()->route('materials.index')->withStatus('Producto agregado correctamente.');
    }

    public function show(Product $material){

        $solds = $material->solds()->latest()->limit(25)->get();

        $receiveds = $material->receiveds()->latest()->limit(25)->get();

        return view('inventory.materials.show', compact('material', 'solds', 'receiveds'));
    }

    public function edit(Product $material){

        $categories = $this->categoryModel->pluck('name','id');

        return view('inventory.materials.edit', compact('material', 'categories'));
    }

    public function update(ProductRequest $request, Product $material){

        $material->update($request->all());

        return redirect()->route('materials.index')->withStatus('Materia Prima actualizado correctamente.');
    }

    public function destroy(Product $material){

        $material->delete();

        return redirect()->route('materials.index')->withStatus('Materia Prima eliminado correctamente.');
    }
}
