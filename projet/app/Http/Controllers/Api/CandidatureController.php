<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CandidatureRepositoryInterface;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    protected $repository;

    public function __construct(CandidatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annonce_id' => 'required|exists:annonces,id',
            'cv' => 'required|string',
            'lettre_motivation' => 'required|string',
            'statut' => 'required|in:en_attente,acceptee,refusee',
        ]);

        $validated['candidat_id'] = auth()->user()->id;

        try {
            $candidature = $this->repository->store($validated);
            return response()->json($candidature, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}