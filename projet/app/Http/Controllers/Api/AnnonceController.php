<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AnnonceRepositoryInterface;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    protected $repository;

    public function __construct(AnnonceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:ouverte,fermée',
        ]);

        $validated['recruteur_id'] = auth()->user()->id;

        try {
            $annonce = $this->repository->store($validated);
            return response()->json($annonce, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

