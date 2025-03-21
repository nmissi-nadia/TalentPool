<?php

namespace App\Http\Controllers\Api;

use App\Models\Candidature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Candidature::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        $validated['candidat_id'] = auth()->user()->id;

        $candidature = Candidature::create($validated);

        return response()->json($candidature, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en attente,s,refusée',
        ]);

        $validated['candidat_id'] = auth()->user()->id;

        $candidature = Candidature::create($validated);

        return response()->json($candidature, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $candidature = Candidature::find($id);
        $this->authorize('view', $candidature);

        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        return response()->json($candidature, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $candidature = Candidature::find($id);

        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        return response()->json($candidature, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $candidature = Candidature::find($id);

        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        $validated = $request->validate([
            'statut' => 'in:en_attente,acceptee,refusee',
            'cv' => 'string',
            'lettre_motivation' => 'string',
        ]);

        $candidature->update($validated);

        return response()->json($candidature, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $candidature = Candidature::find($id);

        if (!$candidature) {
            return response()->json(['message' => 'Candidature non trouvée'], 404);
        }

        $candidature->delete();

        return response()->json(['message' => 'Candidature supprimée avec succès'], 200);
    }
    // fonction pour affiché statistique des candidature en utilisant query builder en calcul aussi le ombre total des candidats qui ont postuler
    public function stats()
    {
        $stats = Candidature::select('statut', DB::raw('COUNT(*) as count'))    
            ->groupBy('statut')
            ->get();

        $total = Candidature::count();

        return response()->json([
            'statistiques par statut' => $stats,
            'total candidatures' => $total
        ], 200);
    }
}
