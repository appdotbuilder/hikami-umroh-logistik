<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Accommodation
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $location
 * @property string $address
 * @property int|null $star_rating
 * @property string|null $facilities
 * @property float|null $distance_to_haram
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JamaahAssignment> $assignments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereDistanceToHaram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereFacilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereStarRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Accommodation byLocation(string $location)

 * 
 * @mixin \Eloquent
 */
class Accommodation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'location',
        'address',
        'star_rating',
        'facilities',
        'distance_to_haram',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'distance_to_haram' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the assignments for the accommodation.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(JamaahAssignment::class);
    }

    /**
     * Scope a query to only include accommodations in specific location.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $location
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }
}