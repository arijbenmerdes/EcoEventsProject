<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'type',
        'age_min',
        'age_max',
        'profession',
        'secteur',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
        'age_min' => 'integer',
        'age_max' => 'integer'
    ];

    // Enumérations
    const TYPE_INDIVIDUEL = 'individuel';
    const TYPE_GROUPE = 'groupe';
    const TYPE_INSTITUTION = 'institution';

    const SECTEUR_EDUCATION = 'education';
    const SECTEUR_SANTE = 'sante';
    const SECTEUR_ENTREPRISE = 'entreprise';
    const SECTEUR_PUBLIC = 'public';
    const SECTEUR_ASSOCIATIF = 'associatif';
    const SECTEUR_AGRICULTURE = 'agriculture';

    /**
     * Boot function for slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($target) {
            if (empty($target->slug)) {
                $target->slug = Str::slug($target->nom);
            }
        });

        static::updating(function ($target) {
            if ($target->isDirty('nom') && empty($target->slug)) {
                $target->slug = Str::slug($target->nom);
            }
        });
    }

    /**
     * Obtenir tous les types possibles
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_INDIVIDUEL => 'Individuel',
            self::TYPE_GROUPE => 'Groupe',
            self::TYPE_INSTITUTION => 'Institution'
        ];
    }

    /**
     * Obtenir tous les secteurs possibles
     */
    public static function getSecteurs(): array
    {
        return [
            self::SECTEUR_EDUCATION => 'Éducation',
            self::SECTEUR_SANTE => 'Santé',
            self::SECTEUR_ENTREPRISE => 'Entreprise',
            self::SECTEUR_PUBLIC => 'Public',
            self::SECTEUR_ASSOCIATIF => 'Associatif',
            self::SECTEUR_AGRICULTURE => 'Agriculture'
        ];
    }

    /**
     * Relation : une cible peut appartenir à plusieurs campagnes
     */
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_target')
                    ->withTimestamps();
    }

    /**
     * Scope pour les cibles actives
     */
    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    /**
     * Scope pour les cibles par type
     */
    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope pour les cibles par secteur
     */
    public function scopeParSecteur($query, $secteur)
    {
        return $query->where('secteur', $secteur);
    }

    /**
     * Getter pour la plage d'âge formatée
     */
    public function getPlageAgeAttribute(): string
    {
        if ($this->age_min && $this->age_max) {
            return "{$this->age_min} - {$this->age_max} ans";
        } elseif ($this->age_min) {
            return "À partir de {$this->age_min} ans";
        } elseif ($this->age_max) {
            return "Jusqu'à {$this->age_max} ans";
        }

        return 'Non spécifié';
    }
}
