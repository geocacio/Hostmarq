<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Weapon;
use Illuminate\Http\Request;

class WeaponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Weapon::query()->where('user_id', $user->id);
        $search = $request->search;

        if($request->has('search')){
            $query->where('number_sigma', 'like', '%'.$search.'%')
                ->orWhereHas('caliber', function($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
        }

        $weapons = $query->with('caliber', 'model', 'type')->paginate(12);
        return response()->json($weapons);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'number_sigma' => 'required',
            'origin' => 'required',
            'caliber_id' => 'required',
            'model_id' => 'required',
            'type_id' => 'required',
        ]);
        
        $user = \App\Models\User::find(auth()->user()->id);
        $weapon = $user->weapons()->create($validatedData);

        if ($weapon) {
            return response()->json([
                'success' => 'Arma cadastrada com sucesso!',
                'weapon' => $weapon,
            ], 201);
        }

        return response()->json([
            'error' => 'Erro ao cadastrar arma!',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Weapon $weapon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weapon $weapon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weapon $weapon)
    {
        $validatedData = $request->validate([
            'number_sigma' => 'required',
            'origin' => 'required',
            'caliber_id' => 'required',
            'model_id' => 'required',
            'type_id' => 'required',
        ]);
        
        if ($weapon->update($validatedData)) {
            return response()->json([
                'success' => 'Arma atualizada com sucesso!',
                'weapon' => $weapon,
            ]);
        }

        return response()->json([
            'error' => 'Erro ao atualizar arma!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weapon $weapon)
    {
        if ($weapon->delete()) {
            return response()->json([
                'success' => 'Arma deletada com sucesso!',
            ]);
        }

        return response()->json([
            'error' => 'Erro ao deletar arma!',
        ], 500);
    }
}
