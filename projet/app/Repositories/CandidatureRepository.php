<?php

namespace App\Repositories;

use App\Interfaces\CandidatureRepositoryInterface;
use App\Models\Candidature;
use Illuminate\Support\Facades\DB;

class CandidatureRepository implements CandidatureRepositoryInterface
{
    public function store($data)
    {
        return Candidature::create($data);
    }

    public function update($data, $id)
    {
        $candidature = Candidature::findOrFail($id);
        $candidature->update($data);
        return $candidature;
    }

    public function destroy($id)
    {
        $candidature = Candidature::findOrFail($id);
        $candidature->delete();
        return true;
    }

    public function stats()
    {
        $stats = Candidature::select('statut', DB::raw('COUNT(*) as count'))
            ->groupBy('statut')
            ->get();

        $total = Candidature::count();

        return [
            'statistiques par statut' => $stats,
            'total candidatures' => $total
        ];
    }
}
