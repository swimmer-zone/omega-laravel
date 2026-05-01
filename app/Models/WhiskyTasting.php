<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WhiskyTasting extends Model
{
    protected $fillable = [
        'brand',
        'name',
        'strength',
        'whisky_country_id',
        'whisky_region_id',
        'whisky_type_id',
        'whisky_cask_type_id',
        'date_of_tasting',
        'location',
        'whisky_flavour_id',
        'whisky_finish_id',
        'notes',
        'rating',
        'whisky_distillery_id',
        'would_buy',
        'age',
        'url',
        'glance',
        'whisky_color_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(WhiskyCountry::class, 'whisky_country_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(WhiskyRegion::class, 'whisky_region_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(WhiskyType::class, 'whisky_type_id');
    }

    public function caskType(): BelongsTo
    {
        return $this->belongsTo(WhiskyCaskType::class, 'whisky_cask_type_id');
    }

    public function finish(): BelongsTo
    {
        return $this->belongsTo(WhiskyFinish::class, 'whisky_finish_id');
    }

    public function distillery(): BelongsTo
    {
        return $this->belongsTo(WhiskyDistillery::class, 'whisky_distillery_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(WhiskyColor::class, 'whisky_color_id');
    }

    public function flavours()
    {
        return $this->belongsToMany(
            WhiskyFlavour::class,
            'whisky_flavour_whisky_tasting'
        );
    }
}
