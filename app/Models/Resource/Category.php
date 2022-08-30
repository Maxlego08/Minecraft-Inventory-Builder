<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Category
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property Category[] $subCategories
 * @method static Category create(array $values)
 */
class Category extends Model
{
    use HasFactory;

    protected $table = "resource_categories";

    protected $fillable = [
        'name',
        'category_id',
    ];

    /**
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return Str::slug($this->name);
    }

}
