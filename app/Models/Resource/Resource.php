<?php

namespace App\Models\Resource;

use App\Code\BBCode;
use App\Models\File;
use App\Models\User;
use App\Traits\ReviewStarts;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class Plugin
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $tag
 * @property string $unique_id
 * @property int $price
 * @property int $user_id
 * @property int $version_id
 * @property int $category_id
 * @property bool $deleted
 * @property bool $is_pending
 * @property User $user
 * @property Carbon $created_at;
 * @property Carbon $updated_at;
 * @property boolean $is_unique;
 * @property File $icon;
 * @property Version $version;
 * @property Category $category;
 * @method static Resource find(int $id)
 * @method static Resource findOrFail(int $id)
 * @method static Resource create(array $values)
 */
class Resource extends Model
{
    use HasFactory, ReviewStarts;

    protected $table = "resource_resources";

    protected $fillable = ['category_id', 'user_id', 'image_id', 'version_id', 'name', 'price', 'description', 'tag', 'is_display', 'is_pending', 'source_code_link', 'donation_link', 'discord_server_id', 'bstats_id', 'contributors', 'required_dependencies', 'optional_dependencies', 'supported_languages', 'link_information', 'link_support', 'versions', 'version_base_mc', 'lang_support'];

    /**
     * The icon
     *
     * @return BelongsTo
     */
    public function icon(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    /**
     * The author
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Versions
     *
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    public function countReviews()
    {
        return Cache::remember("count.review::$this->id", 3600, function () {
            return $this->reviews()->count();
        });
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
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
        return Cache::remember("count.score::$this->id", 1, function () {
            return $this->reviews()->avg('score');
        });
    }

    /**
     * Count total download
     *
     * @return mixed
     */
    public function countDownload(): mixed
    {
        return Cache::remember("count.download::$this->id", 3600, function () {
            return $this->version()->sum('download');
        });
    }

    /**
     * The version
     *
     * @return BelongsTo
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class);
    }

    /**
     * Clear cache
     *
     * count.download
     * count.score
     * count.review
     * count.score.version
     * count.review.version
     *
     * @return void
     */
    public function clear(string $key)
    {
        Cache::forget("$key::$this->id");
    }

    /**
     * Resource link
     *
     * @param string $key
     * @return string
     */
    public function link(string $key): string
    {
        switch ($key) {
            case "description":
                return route('resources.view', ['slug' => Str::slug($this->name), 'resource' => $this->id]);
        }
        return "";
    }

    /**
     * BBCode to html
     *
     * @return string
     */
    public function toHTML(): string
    {
        return BBCode::renderAndPurify($this->description);
    }

    public function isModerator()
    {
        $user = user();
        return $user->id == $this->user_id || $user->isModerator();
    }

}
