<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EquipmentDistribution
 *
 * @property int $id
 * @property int $jamaah_id
 * @property int $equipment_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon $distributed_at
 * @property string|null $notes
 * @property int $distributed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jamaah $jamaah
 * @property-read \App\Models\Equipment $equipment
 * @property-read \App\Models\User $distributedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution query()
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereDistributedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereDistributedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereEquipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereJamaahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EquipmentDistribution whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class EquipmentDistribution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jamaah_id',
        'equipment_id',
        'quantity',
        'distributed_at',
        'notes',
        'distributed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'distributed_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jamaah that received the equipment.
     */
    public function jamaah(): BelongsTo
    {
        return $this->belongsTo(Jamaah::class);
    }

    /**
     * Get the equipment that was distributed.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get the user who distributed the equipment.
     */
    public function distributedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'distributed_by');
    }
}