<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\TravelPackage
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int $duration_days
 * @property \Illuminate\Support\Carbon $departure_date
 * @property \Illuminate\Support\Carbon $return_date
 * @property int $capacity
 * @property int $registered_count
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JamaahAssignment> $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereDepartureDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereDurationDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereRegisteredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TravelPackage available()
 * @method static \Database\Factories\TravelPackageFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class TravelPackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'departure_date',
        'return_date',
        'capacity',
        'registered_count',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'departure_date' => 'date',
        'return_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the assignments for the travel package.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(JamaahAssignment::class);
    }

    /**
     * Get the payments for the travel package.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the expenses for the travel package.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Scope a query to only include available packages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->whereIn('status', ['open', 'draft']);
    }

    /**
     * Get remaining capacity.
     *
     * @return int
     */
    public function getRemainingCapacityAttribute(): int
    {
        return $this->capacity - $this->registered_count;
    }

    /**
     * Check if package is full.
     *
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->registered_count >= $this->capacity;
    }
}