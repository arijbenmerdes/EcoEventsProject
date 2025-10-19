<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'reclamation_id'
    ];

    // Relation : une réponse appartient à une réclamation
    public function reclamation()
    {
        return $this->belongsTo(Reclamation::class);
    }

    // Relation avec l'administrateur (user)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
