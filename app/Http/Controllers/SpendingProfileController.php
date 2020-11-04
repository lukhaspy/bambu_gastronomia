<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpendingProfileRequest;
use App\SpendingProfile;
use Illuminate\Http\Request;

class SpendingProfileController extends Controller
{
    private $spendingProfileModel;

    public function __construct(SpendingProfile $spendingProfile)
    {

        $this->spendingProfileModel = $spendingProfile;
    }

    public function index()
    {

        $spendingProfiles = $this->spendingProfileModel->paginate(25);

        return view('inventory.spendingProfile.index', compact('spendingProfiles'));
    }

    public function create()
    {


        return view('inventory.spendingProfile.create');
    }

    public function store(SpendingProfileRequest $request)
    {

        $this->spendingProfileModel->create($request->all());

        return redirect()->route('spendingProfiles.index')->withStatus('Perfil agregado correctamente.');
    }

    public function show(SpendingProfileRequest $spendingProfile)
    {
    }

    public function edit(SpendingProfile $spendingProfile)
    {


        return view('inventory.spendingProfile.edit', compact('spendingProfile'));
    }

    public function update(SpendingProfileRequest $request, SpendingProfile $spendingProfile)
    {


        $spendingProfile->update($request->all());

        return redirect()->route('spendingProfiles.index')->withStatus('Perfil de Gasto actualizado correctamente.');
    }

    public function destroy(SpendingProfile $spendingProfile)
    {
         if ($spendingProfile->transactions()->count()) {
            return redirect()->route('spendingProfiles.index')->withStatus('NO ES POSIBLE ELIMINAR EL PERFIL, YA POSEE GASTOS.');
        }

        $spendingProfile->delete();


        return redirect()->route('spendingProfiles.index')->withStatus('Perfil de Gasto eliminado correctamente.');
    }
}
