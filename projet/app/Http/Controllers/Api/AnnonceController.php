<?php

namespace App\Http\Controllers\Api;

use App\Models\Annonce;
use App\Http\Controllers\Controller;
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
            'statut' => 'required|in:ouverte,fermée',
        ]);

        $validated['id_recruteur'] = auth()->user()->id;

        try {
            $annonce = Annonce::create($validated);
            return response()->json($annonce, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:ouverte,fermée',
        ]);

        $validated['recruteur_id'] = auth()->user()->id;

        try {
            $annonce = Annonce::create($validated);
            return response()->json($annonce, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            'statut' => 'in:ouverte,fermée',
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
    // fonction pour affiché statistique des annonces en utilisant query builder
    public function stats()
    {
        $stats = Annonce::select('statut', DB::raw('COUNT(*) as count'))    
            ->groupBy('statut')
            ->get();

        $total = Annonce::count();

        return response()->json([
            'statistiques par statut' => $stats,
            'total annonces' => $total
        ], 200);
    }
}
