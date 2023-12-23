<?php

namespace App\Models;

use App\Models\Resource\Resource;
use App\Models\Resource\Version;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $reportable_id
 * @property int $user_id
 * @property int $resolved_by
 * @property string $reportable_type
 * @property string $reason
 * @property string $resolution_message
 * @property Carbon $resolved_at
 */
class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportable_id', 'reportable_type', 'user_id', 'reason',
        'resolved_by', 'resolution_message', 'resolved_at'
    ];

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Get the icon for the report type.
     *
     * @return string
     */
    public function getReportTypeIconAttribute(): string
    {
        return match ($this->reportable_type) {
            Version::class => 'fas fa-code-branch',
            Resource::class => 'fas fa-file-alt',
            default => 'fas fa-flag',
        };
    }

    /**
     * Get the name for the report type.
     *
     * @return string
     */
    public function displayName(): string
    {
        $icon = "<i class='{$this->getReportTypeIconAttribute()}'></i>";
        $name = match ($this->reportable_type) {
            Version::class => 'Version',
            Resource::class => 'Resource',
            default => 'Autre',
        };
        $color = match ($this->reportable_type) {
            Version::class => '#27d5e8',
            Resource::class => '#15e8a2',
            default => '#7da660',
        };
        return "<a href='{$this->getURL()}' target='_blank' style='color: $color'>$icon $name</a>";
    }

    /**
     * Get the url for the report type.
     *
     * @return string
     */
    public function getURL(): string
    {
        return match ($this->reportable_type) {
            Version::class => route('resources.update.id', $this->reportable_id),
            Resource::class => route('resources.view.id',  $this->reportable_id),
            default => '',
        };
    }

}
