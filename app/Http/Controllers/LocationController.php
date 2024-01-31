<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Club $club)
    {
        $locations = $club->locations;
        return response()->json($locations);
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
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $location = $club->locations()->create($validated);

        if($location){
            return response()->json([
                'status' => 'success',
                'message' => 'Local criado com sucesso!',
                'event' => $location,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao criar local!',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club, Location $location)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        if($location->update($validated)){
            return response()->json([
                'status' => 'success',
                'message' => 'Local atualizado com sucesso!',
                'event' => $location,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar local!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, Location $location)
    {
        if($location->delete()){
            return response()->json([
                'status' => 'success',
                'message' => 'Local deletado com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao deletar local!',
        ], 500);
    }
}
