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
    public function index(Club $club)
    {
        $weapons = $club->weapons;
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
    public function store(Request $request, Club $club)
    {
        $validatedData = $request->validate([
            'number_sigma' => 'required',
            'origin' => 'required',
            'caliber_id' => 'required',
            'model_id' => 'required',
            'type_id' => 'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $weapon = $club->weapons()->create($validatedData);

        if ($weapon) {
            return response()->json([
                'status' => 'success',
                'message' => 'Arma cadastrada com sucesso!',
                'weapon' => $weapon,
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao cadastrar arma!',
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
    public function update(Request $request, Club $club, Weapon $weapon)
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
                'status' => 'success',
                'message' => 'Arma atualizada com sucesso!',
                'weapon' => $weapon,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar arma!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, Weapon $weapon)
    {
        if ($weapon->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Arma deletada com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao deletar arma!',
        ], 500);
    }
}
