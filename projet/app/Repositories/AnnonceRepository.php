<?php

namespace App\Repositories;

use App\Interfaces\AnnonceRepositoryInterface;
use App\Models\Annonce;
use Illuminate\Support\Facades\DB;

class AnnonceRepository implements AnnonceRepositoryInterface
{
    public function store($data)
    {
        return Annonce::create($data);
    }

    public function update($data, $id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->update($data);
        return $annonce;
    }

    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);
        $annonce->delete();
        return true;
    }

    public function stats()
    {
        $stats = Annonce::select('statut', DB::raw('COUNT(*) as count'))
            ->groupBy('statut')
            ->get();

        $total = Annonce::count();

        return [
            'statistiques par statut' => $stats,
            'total annonces' => $total
        ];
    }
}


