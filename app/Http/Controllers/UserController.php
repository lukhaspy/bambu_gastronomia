<?php

namespace App\Http\Controllers;

use App\Branch;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller{

    private $userModel;
    private $branchModel;

    public function __construct(User $userModel, Branch $branchModel){
        $this->userModel = $userModel;
        $this->branchModel = $branchModel;
    }

    public function index(User $model){

        $users = $this->userModel->where('id', '<>', 1)
                ->whereHas('branches', function (Builder $query) {
                    $query->where('id', session('dBranch'));
                })
                ->paginate(25);

        return view('users.index', compact('users'));
    }

    public function create(){

        $branches = $this->branchModel->pluck('name', 'id');

        return view('users.create', compact('branches'));
    }

    public function store(UserRequest $request){

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $input['default_branch'] = $input['branches'][0];

        $user = $this->userModel->create($input);
        $user->branches()->attach($input['branches']);

        return redirect()->route('users.index')->withStatus('User successfully created.');
    }

    public function edit(User $user){

        $user->branches = $user->branches()->pluck('id')->toArray();
        $branches = $this->branchModel->pluck('name', 'id');

        return view('users.edit', compact('user', 'branches'));
    }

    public function update(UserRequest $request, User $user){

        $input = $request->all();

        if($input['password'] != null){
            $input['password'] = Hash::make($request->get('password'));
        }

        $input['default_branch'] = $input['branches'][0];
        $user->update($request->all());
        $user->branches()->sync($input['branches']);

        return redirect()->route('users.index')->withStatus('User successfully updated.');
    }

    public function destroy(User $user){

        $user->delete();

        return redirect()->route('users.index')->withStatus('Usuario eliminado correctamente.');
    }
}
