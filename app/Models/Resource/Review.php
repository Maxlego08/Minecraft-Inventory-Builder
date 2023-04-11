<?php

namespace App\Models\Resource;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

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
}
