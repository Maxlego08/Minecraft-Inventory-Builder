<?php

namespace App\Models\Resource;

use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    use HasFactory;

    protected $table = "resource_resources";

    protected $fillable = [
        'category_id',
        'user_id',
        'image_id',
        'version_id',
        'name',
        'price',
        'description',
        'tag',
        'is_display',
        'is_pending',
        'source_code_link',
        'donation_link',
        'discord_server_id',
        'bstats_id',
        'contributors',
        'required_dependencies',
        'optional_dependencies',
        'supported_languages',
        'link_information',
        'link_support',
        'versions',
        'version_base_mc',
        'lang_support'];

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
     * The version
     *
     * @return BelongsTo
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class);
    }

}
