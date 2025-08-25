<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Jamaah
 *
 * @property int $id
 * @property int $user_id
 * @property string $nik
 * @property string $full_name
 * @property string $gender
 * @property string $place_of_birth
 * @property \Illuminate\Support\Carbon $date_of_birth
 * @property string $nationality
 * @property string|null $occupation
 * @property string $emergency_contact_name
 * @property string $emergency_contact_phone
 * @property string|null $medical_notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EquipmentDistribution> $equipmentDistributions
 * @property-read \App\Models\JamaahAssignment|null $assignment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah query()
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereEmergencyContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereMedicalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereNationality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah wherePlaceOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Jamaah byStatus(string $status)
 * @method static \Database\Factories\JamaahFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Jamaah extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'nik',
        'full_name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'nationality',
        'occupation',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jamaah';

    /**
     * Get the user that owns the jamaah record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the documents for the jamaah.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the equipment distributions for the jamaah.
     */
    public function equipmentDistributions(): HasMany
    {
        return $this->hasMany(EquipmentDistribution::class);
    }

    /**
     * Get the assignment for the jamaah.
     */
    public function assignment(): HasOne
    {
        return $this->hasOne(JamaahAssignment::class);
    }

    /**
     * Get the payments for the jamaah.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope a query to only include jamaah with specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the jamaah's age.
     *
     * @return int
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }
}