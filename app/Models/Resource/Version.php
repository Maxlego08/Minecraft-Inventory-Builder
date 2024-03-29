<?php

namespace App\Models\Resource;

use App\Code\BBCodeUtils;
use App\Models\File;
use App\Models\Like;
use App\Models\Report;
use App\Traits\ReviewStarts;
use App\Utils\Likeable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
class Version extends Model implements Likeable
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
     * Like sur la version
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
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
     * @return HasMany
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
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
        return Cache::remember("count.score.version::$this->id", 86400, function () {
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

    /**
     * count.score.version
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key)
    {
        Cache::forget("$key::$this->id");
    }

    public function countReviews()
    {
        return Cache::remember("count.review.version::$this->id", 3600, function () {
            return $this->reviews()->count();
        });
    }

    public function startPercentage(): float|int
    {
        return Cache::remember("start.percent::$this->id", 86400, function () {
            $value = $this->scoreReviews();
            return ($value * 100) / 5;
        });
    }

    /**
     * Download link
     *
     * @return string
     */
    public function download(): string
    {
        return route('resources.download', ['resource' => $this->resource_id, 'version' => $this->id]);
    }

    public function getContentName(): string
    {
        return "version $this->title.$this->id";
    }

    public function getCacheName(): string
    {
        return "version::$this->id";
    }

    public function toShortHTML(): string
    {
        return BBCodeUtils::renderAndPurify(Str::limit($this->description, 500));
    }


}
