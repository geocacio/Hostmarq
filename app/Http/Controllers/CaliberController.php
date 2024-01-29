<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use Illuminate\Http\Request;

class CaliberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calibers = Caliber::all();
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);
        $validatedData['slug'] = Caliber::uniqSlug($validatedData['name']);

        $caliber = Caliber::create($validatedData);

        if ($caliber) {
            return response()->json([
                'status' => 'success',
                'message' => 'Calibre cadastrado com sucesso!',
                'data' => $caliber
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao cadastrar calibre, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Caliber $caliber)
    {
        //
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
    public function update(Request $request, Caliber $caliber)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        if($caliber->update($validatedData)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Calibre atualizado com sucesso!',
                'data' => $caliber
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar calibre, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Caliber $caliber)
    {
        if($caliber->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Calibre removido com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao remover calibre, por favor tente novamente mais tarde!',
        ]);
    }
}
