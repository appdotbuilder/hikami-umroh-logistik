<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\JamaahAssignment
 *
 * @property int $id
 * @property int $jamaah_id
 * @property int $travel_package_id
 * @property int|null $accommodation_id
 * @property int|null $departure_flight_id
 * @property int|null $return_flight_id
 * @property string|null $room_number
 * @property string|null $seat_number_departure
 * @property string|null $seat_number_return
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jamaah $jamaah
 * @property-read \App\Models\TravelPackage $travelPackage
 * @property-read \App\Models\Accommodation|null $accommodation
 * @property-read \App\Models\Flight|null $departureFlight
 * @property-read \App\Models\Flight|null $returnFlight
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereAccommodationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereDepartureFlightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereJamaahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereReturnFlightId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereSeatNumberDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereSeatNumberReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereTravelPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JamaahAssignment whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class JamaahAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jamaah_id',
        'travel_package_id',
        'accommodation_id',
        'departure_flight_id',
        'return_flight_id',
        'room_number',
        'seat_number_departure',
        'seat_number_return',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jamaah for this assignment.
     */
    public function jamaah(): BelongsTo
    {
        return $this->belongsTo(Jamaah::class);
    }

    /**
     * Get the travel package for this assignment.
     */
    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class);
    }

    /**
     * Get the accommodation for this assignment.
     */
    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class);
    }

    /**
     * Get the departure flight for this assignment.
     */
    public function departureFlight(): BelongsTo
    {
        return $this->belongsTo(Flight::class, 'departure_flight_id');
    }

    /**
     * Get the return flight for this assignment.
     */
    public function returnFlight(): BelongsTo
    {
        return $this->belongsTo(Flight::class, 'return_flight_id');
    }
}