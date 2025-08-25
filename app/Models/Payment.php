<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $jamaah_id
 * @property int $travel_package_id
 * @property string $invoice_number
 * @property float $amount
 * @property string $payment_method
 * @property string $status
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property string|null $notes
 * @property string|null $receipt_path
 * @property int $recorded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jamaah $jamaah
 * @property-read \App\Models\TravelPackage $travelPackage
 * @property-read \App\Models\User $recordedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereJamaahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReceiptPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTravelPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment byStatus(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment overdue()

 * 
 * @mixin \Eloquent
 */
class Payment extends Model
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
        'invoice_number',
        'amount',
        'payment_method',
        'status',
        'due_date',
        'paid_at',
        'notes',
        'receipt_path',
        'recorded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jamaah for this payment.
     */
    public function jamaah(): BelongsTo
    {
        return $this->belongsTo(Jamaah::class);
    }

    /**
     * Get the travel package for this payment.
     */
    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class);
    }

    /**
     * Get the user who recorded this payment.
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include payments with specific status.
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
     * Scope a query to only include overdue payments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                    ->where('due_date', '<', now());
    }

    /**
     * Check if payment is overdue.
     *
     * @return bool
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }
}