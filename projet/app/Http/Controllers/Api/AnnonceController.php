<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Annonce::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:active,fermee',
            'id_recruteur' => 'required|exists:users,id',
        ]);

        $annonce = Annonce::create($validated);

        return response()->json($annonce, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:active,fermee',
            'id_recruteur' => 'required|exists:users,id',
        ]);

        $annonce = Annonce::create($validated);

        return response()->json($annonce, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée'], 404);
        }

        return response()->json($annonce, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Annonce $annonce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée'], 404);
        }

        $validated = $request->validate([
            'titre' => 'string|max:255',
            'description' => 'string',
            'statut' => 'in:active,fermee',
        ]);

        $annonce->update($validated);

        return response()->json($annonce, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $annonce = Annonce::find($id);

        if (!$annonce) {
            return response()->json(['message' => 'Annonce non trouvée'], 404);
        }

        $annonce->delete();

        return response()->json(['message' => 'Annonce supprimée avec succès'], 200);
    }
}
