<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property int $jamaah_id
 * @property string $type
 * @property string $title
 * @property string $file_path
 * @property string $file_name
 * @property string $file_size
 * @property string $mime_type
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Jamaah $jamaah
 * @property-read \App\Models\User|null $reviewer
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereJamaahId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document byStatus(string $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Document byType(string $type)

 * 
 * @mixin \Eloquent
 */
class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jamaah_id',
        'type',
        'title',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'status',
        'notes',
        'expiry_date',
        'reviewed_at',
        'reviewed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jamaah that owns the document.
     */
    public function jamaah(): BelongsTo
    {
        return $this->belongsTo(Jamaah::class);
    }

    /**
     * Get the user who reviewed the document.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include documents with specific status.
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
     * Scope a query to only include documents with specific type.
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
     * Check if document is expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if document expires soon (within 30 days).
     *
     * @return bool
     */
    public function expiresSoon(): bool
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now()) <= 30;
    }
}