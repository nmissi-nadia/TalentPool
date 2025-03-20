<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'description',
        'id_candidat',
        'id_recruteur',
        'statut'
    ];
    
    public function recruteur()
    {
        return $this->belongsTo(User::class);
    }
}
