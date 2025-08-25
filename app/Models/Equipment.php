<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Equipment
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $stock_quantity
 * @property int $distributed_quantity
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EquipmentDistribution> $distributions
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereDistributedQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereStockQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Equipment available()
 * @method static \Database\Factories\EquipmentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Equipment extends Model
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
        'stock_quantity',
        'distributed_quantity',
        'status',
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'equipment';

    /**
     * Get the distributions for the equipment.
     */
    public function distributions(): HasMany
    {
        return $this->hasMany(EquipmentDistribution::class);
    }

    /**
     * Scope a query to only include available equipment.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Get remaining stock.
     *
     * @return int
     */
    public function getRemainingStockAttribute(): int
    {
        return $this->stock_quantity - $this->distributed_quantity;
    }

    /**
     * Check if equipment is out of stock.
     *
     * @return bool
     */
    public function isOutOfStock(): bool
    {
        return $this->remaining_stock <= 0;
    }
}