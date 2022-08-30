<?php

namespace App\Models\Resource;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property File $file
 * @property Resource $resource
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \App\Models\MinecraftVersion find(int $id)
 * @method static Version create(array $values)
 */
class Version extends Model
{
    use HasFactory;

    protected $table = "resource_versions";

    protected $fillable = [
        'version',
        'resource_id',
        'file_id',
        'download',
        'title',
        'description',
        'updated_at',
    ];

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


}
