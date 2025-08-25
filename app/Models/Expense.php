<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Expense
 *
 * @property int $id
 * @property int|null $travel_package_id
 * @property string $category
 * @property string $description
 * @property float $amount
 * @property \Illuminate\Support\Carbon $expense_date
 * @property string|null $receipt_path
 * @property int $recorded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TravelPackage|null $travelPackage
 * @property-read \App\Models\User $recordedBy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereExpenseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereReceiptPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereTravelPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense byCategory(string $category)

 * 
 * @mixin \Eloquent
 */
class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'travel_package_id',
        'category',
        'description',
        'amount',
        'expense_date',
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
        'expense_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the travel package for this expense.
     */
    public function travelPackage(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class);
    }

    /**
     * Get the user who recorded this expense.
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope a query to only include expenses with specific category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}