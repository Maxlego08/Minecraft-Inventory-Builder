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
 * @property Resource[] $resources
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
     * Retourne-les resources de cette catégorie
     *
     * @return HasMany
     */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

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

    /**
     * Compte le nombre de resource dans une catégorie
     *
     * @return int
     */
    public function countResources(): int
    {
        // Si c'est une sous-catégorie
        if ($this->category_id != null) {
            return Resource::where('category_id', $this->id)->count();
        } else {
            // Sinon, on va compter le nombre de resource dans la catégorie mère
            $categories = $this->subCategories->map(function ($category){
               return $category->id;
            });
            return Resource::whereIn('category_id', $categories)->count();
        }
    }

}
