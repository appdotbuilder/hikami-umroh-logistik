<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Flight
 *
 * @property int $id
 * @property string $flight_number
 * @property string $airline
 * @property string $departure_airport
 * @property string $arrival_airport
 * @property \Illuminate\Support\Carbon $departure_time
 * @property \Illuminate\Support\Carbon $arrival_time
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JamaahAssignment> $departureAssignments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JamaahAssignment> $returnAssignments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Flight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereAirline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereArrivalAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereArrivalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereDepartureAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereDepartureTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereFlightNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight byType(string $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight byStatus(string $status)

 * 
 * @mixin \Eloquent
 */
class Flight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'flight_number',
        'airline',
        'departure_airport',
        'arrival_airport',
        'departure_time',
        'arrival_time',
        'type',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the assignments for departure flights.
     */
    public function departureAssignments(): HasMany
    {
        return $this->hasMany(JamaahAssignment::class, 'departure_flight_id');
    }

    /**
     * Get the assignments for return flights.
     */
    public function returnAssignments(): HasMany
    {
        return $this->hasMany(JamaahAssignment::class, 'return_flight_id');
    }

    /**
     * Scope a query to only include flights with specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include flights with specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}