<?php

namespace App\Models\Resource;

use App\Models\User;
use App\Traits\ReviewStarts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $score
 * @property Resource $resource
 * @property Version $version
 * @property User $user
 */
class Review extends Model
{
    use HasFactory, ReviewStarts;

    protected $table = "resource_reviews";

    protected $fillable = ['user_id', 'resource_id', 'version_id', 'score', 'review', 'response'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class, 'version_id');
    }

    /**
     * Display the rating stars
     *
     * @return string
     */
    public function reviewScore(): string
    {
        return $this->reviewScores($this->score);
    }

    public function isModerator(): bool
    {
        $user = user();
        return $user->role->isModerator() || $user->id === $this->user_id;
    }
}
