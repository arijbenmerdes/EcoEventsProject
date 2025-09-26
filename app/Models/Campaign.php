<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'objective',
        'start_date',
        'end_date',
        'budget',
        'status',
        'type',
        'ecological_focus',
        'location',
        'image_url',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'budget' => 'decimal:2',
    ];

    // Enumérations
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_PAUSED = 'paused';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const TYPE_AWARENESS = 'awareness';
    const TYPE_ACTION = 'action';
    const TYPE_FUNDRAISING = 'fundraising';
    const TYPE_VOLUNTEERING = 'volunteering';

    const ECOLOGICAL_CLIMATE = 'climate';
    const ECOLOGICAL_BIODIVERSITY = 'biodiversity';
    const ECOLOGICAL_WASTE = 'waste';
    const ECOLOGICAL_WATER = 'water';
    const ECOLOGICAL_ENERGY = 'energy';

    /**
     * Obtenir tous les statuts possibles
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_PAUSED => 'En pause',
            self::STATUS_COMPLETED => 'Terminée',
            self::STATUS_CANCELLED => 'Annulée'
        ];
    }

    /**
     * Obtenir tous les types possibles
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_AWARENESS => 'Sensibilisation',
            self::TYPE_ACTION => 'Action terrain',
            self::TYPE_FUNDRAISING => 'Collecte de fonds',
            self::TYPE_VOLUNTEERING => 'Bénévolat'
        ];
    }

    /**
     * Obtenir tous les focus écologiques possibles
     */
    public static function getEcologicalFocuses(): array
    {
        return [
            self::ECOLOGICAL_CLIMATE => 'Climat',
            self::ECOLOGICAL_BIODIVERSITY => 'Biodiversité',
            self::ECOLOGICAL_WASTE => 'Déchets',
            self::ECOLOGICAL_WATER => 'Eau',
            self::ECOLOGICAL_ENERGY => 'Énergie'
        ];
    }

    /**
     * Relation : une campagne peut avoir plusieurs cibles (many-to-many)
     */
    public function targets()
    {
        return $this->belongsToMany(Target::class, 'campaign_target')
                    ->withTimestamps();
    }

    /**
     * Relation : une campagne appartient à un créateur
     */
    public function creator()
    {
       // return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Vérifier si la campagne est en cours
     */
    public function getIsOngoingAttribute(): bool
    {
        return $this->status === self::STATUS_ACTIVE &&
               $this->start_date <= now() &&
               ($this->end_date === null || $this->end_date >= now());
    }

    /**
     * Calculer le nombre total de personnes ciblées
     */
    public function getNombreCiblesAttribute(): int
    {
        return $this->targets()->count();
    }

    /**
     * Scope pour les campagnes actives
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope pour les campagnes par type de cible
     */
    public function scopeAvecTypeCible($query, $typeCible)
    {
        return $query->whereHas('targets', function($q) use ($typeCible) {
            $q->where('type', $typeCible);
        });
    }

    /**
     * Scope pour les campagnes par secteur de cible
     */
    public function scopeAvecSecteurCible($query, $secteur)
    {
        return $query->whereHas('targets', function($q) use ($secteur) {
            $q->where('secteur', $secteur);
        });
    }
}
