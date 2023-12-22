<?php

namespace App\Models\Resource;

use App\Code\BBCode;
use App\Models\File;
use App\Models\Like;
use App\Models\MinecraftVersion;
use App\Models\User;
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
 * Class Plugin
 * @package App\Models
 * @property int $id
 * @property int $image_id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $tag
 * @property string $unique_id
 * @property int $price
 * @property int $user_id
 * @property int $version_id
 * @property int $category_id
 * @property bool $is_pending
 * @property bool $is_deleted
 * @property User $user
 * @property Carbon $created_at;
 * @property Carbon $updated_at;
 * @property boolean $is_unique;
 * @property File $icon;
 * @property Version $version;
 * @property Category $category;
 * @property String $versions;
 * @property Access[] $buyers;
 * @property Review[] $reviews;
 * @method static Resource find(int $id)
 * @method static Resource findOrFail(int $id)
 * @method static Resource create(array $values)
 */
class Resource extends Model implements Likeable
{
    use HasFactory, ReviewStarts;

    protected $table = "resource_resources";

    protected $fillable = ['category_id', 'user_id', 'image_id', 'version_id',
        'name', 'price', 'description', 'tag', 'is_display',
        'is_pending', 'source_code_link', 'is_deleted',
        'donation_link', 'discord_server_id',
        'bstats_id', 'contributors', 'required_dependencies',
        'optional_dependencies', 'link_information', 'link_support', 'versions',
        'version_base_mc', 'lang_support'];

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
     * @return HasMany
     */
    public function buyers(): HasMany
    {
        return $this->hasMany(Access::class);
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
     * Like d'une resource
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
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
        return Cache::remember("count.score::$this->id", 86400, function () {
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
        return Cache::remember("count.download::$this->id", 86400, function () {
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
     * The number of versions
     *
     * @return mixed
     */
    public function countUpdates(): mixed
    {
        return Cache::remember("count.versions::$this->id", 86400, function () {
            return $this->versions()->count();
        });
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

    public function getSupportedVersions(): mixed
    {
        return Cache::remember("supported.version::$this->id", 86400, function () {
            return MinecraftVersion::whereIn('id', explode(',', $this->versions))->get()->map(function (MinecraftVersion $version) {
                return $version->version;
            })->implode(', ');
        });
    }

    public function clearReview()
    {
        $this->clear('count.review');
        $this->clear('count.score');
        $this->clear('count.score.version');
        $this->clear('count.review.version');
        $this->clear('last.review');
        $this->clear('start.percent.resource');

        $this->version->clear('start.percent');
        $this->version->clear('count.review.version');
        $this->version->clear('count.score.version');
    }

    /**
     * Clear cache
     *
     * count.download
     * count.score
     * count.review
     * count.score.version
     * count.review.version
     * count.versions
     * supported.version
     * file.information
     * last.review
     * icon.path
     * start.percent.resource
     *
     * resource.version
     * resource.category
     * resource.user
     * resource.icon
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key): void
    {
        Cache::forget("$key::$this->id");
    }

    public function clearVersionUpdate()
    {
        $this->clear('count.download');
        $this->clear('resource.version');
        $this->clear('file.information');
        $this->clear('count.versions');
        $this->clear('count.review.version');
        $this->clear('count.score.version');
    }

    public function getIconPath()
    {
        return Cache::remember("icon.path::$this->id", 86400, function () {
            return $this->icon->getPath();
        });
    }

    public function lastReviews()
    {
        return Cache::remember("last.review::$this->id", 86400, function () {
            return $this->reviews()->orderBy('created_at', 'desc')->limit(5)->get();
        });
    }

    public function fileInformations(): array
    {
        return Cache::remember("file.information::$this->id", 86400, function () {
            return [
                'size' => human_filesize($this->version->file->file_size),
                'extension' => $this->version->file->file_extension,
            ];
        });
    }

    /**
     * Resource link
     *
     * @param string $key
     * @return string
     */
    public function link(string $key): string
    {
        return match ($key) {
            'description' => route('resources.view', ['slug' => Str::slug($this->name), 'resource' => $this->id]),
            'download' => route('resources.download', ['resource' => $this->id, 'version' => $this->version_id]),
            'updates' => route('resources.updates', ['slug' => Str::slug($this->name), 'resource' => $this->id]),
            'reviews' => route('resources.reviews', ['slug' => Str::slug($this->name), 'resource' => $this->id]),
            'buyers' => route('resources.buyers', ['slug' => Str::slug($this->name), 'resource' => $this->id]),
            'versions' => route('resources.versions', ['slug' => Str::slug($this->name), 'resource' => $this->id]),
            'purchase' => route('resources.purchase', ['resource' => $this->id]),
            default => "",
        };
    }

    /**
     * resource name as slug
     *
     * @return string
     */
    public function slug(): string
    {
        return Str::slug($this->name);
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

    public function isModerator(): bool
    {
        $user = user();
        return $user->id == $this->user_id || $user->role->isModerator();
    }

    public function startPercentage(): float|int
    {
        return Cache::remember("start.percent.resource::$this->id", 86400, function () {
            $value = $this->scoreReviews();
            return ($value * 100) / 5;
        });
    }

    public function containsVersion($version): bool
    {
        return str_contains($this->versions, $version);
    }

    /**
     * Cache system
     *
     * @param string $key
     * @return mixed
     */
    public function cache(string $key): mixed
    {
        return Cache::remember("resource.$key::$this->id", 86400, function () use ($key) {
            return match ($key) {
                "version" => $this->version,
                "category" => $this->category,
                "user" => $this->user,
                "icon" => $this->icon,
                default => ""
            };
        });
    }

    /**
     * Return status tag
     *
     * @return string[]
     */
    public function getStatus(): array
    {
        if ($this->is_deleted)
            return [
                'message' => 'deleted',
                'color' => 'red'
            ];
        if ($this->is_pending)
            return [
                'message' => 'pending',
                'color' => '#ca4100'
            ];
        return [
            'message' => 'approved',
            'color' => 'rgb(72, 187, 156)'
        ];
    }

    /**
     * Vérifier si la resource peut être acheté
     *
     * @return bool
     */
    public function canBePurchase(): bool
    {
        if (!isset($this->user->paymentInfo)) return false;
        return $this->user->paymentInfo->sk_live != null || $this->user->paymentInfo->paypal_email != null;
    }

    public function getContentName(): string
    {
        return "resource $this->name.$this->id";
    }

    public function getCacheName(): string
    {
        return "resource::$this->id";
    }
}

