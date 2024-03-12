<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use App\Models\Club;
use Illuminate\Http\Request;

class CaliberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Club $club)
    {
        $query = Caliber::query()->where('club_id', $club->id);
        $search = $request->search;

        if($request->has('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $calibers = $query->paginate(12);
        return response()->json($calibers);
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
            'name' => 'required',
            'type' => 'required',
        ]);
        $validatedData['club_id'] = $club->id;
        $validatedData['slug'] = Caliber::uniqSlug($validatedData['name']);

        $caliber = Caliber::create($validatedData);

        if ($caliber) {
            return response()->json([
                'success' => 'Calibre cadastrado com sucesso!',
                'data' => $caliber
            ]);
        }

        return response()->json([
            'success' => 'Erro ao cadastrar calibre, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club, Caliber $caliber)
    {
        return response()->json($caliber);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caliber $caliber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club, Caliber $caliber)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        if($caliber->update($validatedData)) {
            return response()->json([
                'success' => 'Calibre atualizado com sucesso!',
                'data' => $caliber
            ]);
        }

        return response()->json([
            'success' => 'Erro ao atualizar calibre, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, Caliber $caliber)
    {
        if($caliber->delete()) {
            return response()->json([
                'success' => 'Calibre removido com sucesso!',
            ]);
        }

        return response()->json([
            'success' => 'Erro ao remover calibre, por favor tente novamente mais tarde!',
        ]);
    }
}
