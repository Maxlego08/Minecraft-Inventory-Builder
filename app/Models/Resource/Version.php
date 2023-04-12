<?php

namespace App\Models\Resource;

use App\Models\File;
use App\Models\MinecraftVersion;
use App\Traits\ReviewStarts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

/**
 * Class Version
 * @package App\Models
 * @property int $id
 * @property int $download
 * @property int $resource_id
 * @property int $file_id
 * @property string $title
 * @property string $description
 * @property string $extension
 * @property string $version
 * @property string $file_name
 * @property File $file
 * @property Resource $resource
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Version find(int $id)
 * @method static Version create(array $values)
 */
class Version extends Model
{
    use HasFactory, ReviewStarts;

    protected $table = "resource_versions";

    protected $fillable = ['version', 'resource_id', 'file_id', 'download', 'title', 'description', 'updated_at', 'file_name'];

    /**
     * Retourne la ressource
     *
     * @return BelongsTo
     */
    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Retourne le fichier
     *
     * @return BelongsTo
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Display the rating stars
     *
     * @return string
     */
    public function reviewScore(): string
    {
        return $this->reviewScores($this->scoreReviews());
    }

    public function scoreReviews()
    {
        return Cache::remember("count.score.version::$this->id", 1, function () {
            return $this->reviews()->avg('score');
        });
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'version_id');
    }

    public function countReviews()
    {
        return Cache::remember("count.review.version::$this->id", 3600, function () {
            return $this->reviews()->count();
        });
    }

    public function startPercentage(): float|int
    {
        $value = $this->scoreReviews();
        return ($value * 100) / 5;
    }

}
