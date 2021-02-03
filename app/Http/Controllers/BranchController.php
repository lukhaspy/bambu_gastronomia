<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests\BranchRequest;
use Illuminate\Http\Request;

class BranchController extends Controller{


    private $branchModel;

    public function __construct(Branch $branchModel){
        $this->branchModel = $branchModel;
    }

    public function index(){

        $branches = $this->branchModel->all();

        return view('branches.index', compact('branches'));
    }

    public function create(){
        return view('branches.create');
    }

    public function store(BranchRequest $request){

        $this->branchModel->create($request->all());

        return redirect()->route('branches.index')->withStatus('Sucursal agregado correctamente.');
    }

    public function edit(Branch $branch){

        return view('branches.edit', compact('branch'));
    }

    public function update(BranchRequest $request, Branch $branch){

        $branch->update($request->all());

        return redirect()->route('branches.index')->withStatus('Sucursal actualizado correctamente.');
    }

    public function destroy(Branch $branch){

        $branch->delete();

        return redirect()->route('branches.index')->withStatus('Sucursal eliminado correctamente.');
    }
}
