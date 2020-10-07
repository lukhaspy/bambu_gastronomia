<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCategory;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller{

    private $productModel;
    private $categoryModel;

    public function __construct(Product $productModel, ProductCategory $categoryModel){
        $this->productModel = $productModel;
        $this->categoryModel = $categoryModel;
    }

    public function index(){

        $products = $this->productModel->paginate(25);

        return view('inventory.products.index', compact('products'));
    }

    public function create(){

        $categories = $this->categoryModel->pluck('name','id');

        return view('inventory.products.create', compact('categories'));
    }

    public function store(ProductRequest $request){

        $this->productModel->create($request->all());

        return redirect()->route('products.index')->withStatus('Producto agregado correctamente.');
    }

    public function show(Product $product){

        $solds = $product->solds()->latest()->limit(25)->get();

        $receiveds = $product->receiveds()->latest()->limit(25)->get();

        return view('inventory.products.show', compact('product', 'solds', 'receiveds'));
    }

    public function edit(Product $product){

        $categories = $this->categoryModel->pluck('name','id');

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product){

        $product->update($request->all());

        return redirect()->route('products.index')->withStatus('Producto actualizado correctamente.');
    }

    public function destroy(Product $product){

        $product->delete();

        return redirect()->route('products.index')->withStatus('Producto eliminado correctamente.');
    }
}
