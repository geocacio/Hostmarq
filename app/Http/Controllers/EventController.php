<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Club $club)
    {
        $query = Event::query()->where('club_id', $club->id);
        $search = $request->search;

        if($request->has('search')){
            $query->where('name', 'like', '%'. $search.'%');
        }

        $events = $query->paginate(12);
        return response()->json($events);
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

        $event = $club->events()->create($validated);

        if ($event) {
            return response()->json([
                'success' => 'Evento criado com sucesso!',
                'event' => $event,
            ], 201);
        }

        return response()->json([
            'success' => 'Erro ao criar evento!',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        if ($event->update($validated)) {
            return response()->json([
                'success' => 'Evento atualizado com sucesso!',
                'event' => $event,
            ]);
        }

        return response()->json([
            'success' => 'Erro ao atualizar evento!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club, Event $event)
    {
        if ($event->delete()) {
            return response()->json([
                'success' => 'Evento deletado com sucesso!',
            ]);
        }

        return response()->json([
            'success' => 'Erro ao deletar evento!',
        ], 500);
    }
}
