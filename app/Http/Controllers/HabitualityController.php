<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Habituality;
use App\Models\User;
use Illuminate\Http\Request;

class HabitualityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Club $club)
    {

        $habitualities = $club->habitualities->load('ammunitionHabitualities', 'event', 'location', 'weapon', 'weapon.caliber', 'weapon.model', 'weapon.type');

        return response()->json($habitualities);
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
        $validateHabituality = $request->validate([
            'weapon_id' => 'required',
            'date_time' => 'required',
            'event_id' => 'required',
            'location_id' => 'required',
        ]);
        $validateHabituality['club_id'] = auth()->user()->club_id;

        $validateAmmunitionHabituality = $request->validate([
            'quantity' => 'required',
            'origin' => 'required',
            'type' => 'required',
        ]);

        $user = User::find(auth()->user()->id);
        $habituality = $user->habitualities()->create($validateHabituality);

        if ($habituality) {
            $habituality->ammunitionHabitualities()->create($validateAmmunitionHabituality);
            return response()->json([
                'status' => 'success',
                'message' => 'Habitualidade criada com sucesso!',
                'habituality' => $habituality,
            ], 201);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao criar habitualidade!',
        ], 500);

    }

    /**
     * Display the specified resource.
     */
    public function show(Habituality $habituality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habituality $habituality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habituality $habituality)
    {
        $validateHabituality = $request->validate([
            'weapon_id' => 'required',
            'date_time' => 'required',
            'event_id' => 'required',
            'location_id' => 'required',
        ]);

        $validateAmmunitionHabituality = $request->validate([
            'quantity' => 'required',
            'origin' => 'required',
            'type' => 'required',
        ]);

        if ($habituality->update($validateHabituality)) {
            $habituality->ammunitionHabitualities()->update($validateAmmunitionHabituality);
            return response()->json([
                'status' => 'success',
                'message' => 'Habitualidade atualizada com sucesso!',
                'habituality' => $habituality,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar habitualidade!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habituality $habituality)
    {
        $habituality->ammunitionHabitualities()->delete();

        if ($habituality->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Habitualidade deletada com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao deletar habitualidade!',
        ], 500);
    }
}
