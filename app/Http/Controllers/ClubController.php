<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clubs = Club::all();
        return response()->json($clubs);
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
            'acronym' => 'required',
            'cnpj' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'email_om' => 'required',
            'url' => 'required',
            'app_url' => 'required',
            'logo' => 'required',
            'favicon' => 'required',
            'logo_rodape' => 'required',
            'country' => 'required',
            'city' => 'required',
        ]);
        $validatedData['owner_id'] = auth()->user()->id;
        $validatedData['slug'] = Club::uniqSlug($validatedData['name']);

        $user = auth()->user();
        if ($user->owner) {
            return response()->json(['error' => 'Este usuário já tem um clube!'], 400);
        }

        $club = Club::create($validatedData);
        if($club){
            return response()->json([
                'status' => 'success',
                'message' => 'Clube cadastrado com sucesso!',
                'data' => $club
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao cadastrar clube, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'acronym' => 'required',
            'cnpj' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'email_om' => 'required',
            'url' => 'required',
            'app_url' => 'required',
            'logo' => 'required',
            'favicon' => 'required',
            'logo_rodape' => 'required',
            'country' => 'required',
            'city' => 'required',
        ]);

        if($club->update($validatedData)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Clube atualizado com sucesso!',
                'data' => $club
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao atualizar clube, por favor tente novamente mais tarde!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        if($club->delete()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Clube deletado com sucesso!',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Erro ao deletar clube, por favor tente novamente mais tarde!',
        ]);
    }
}
