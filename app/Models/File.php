<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class File
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $file_size
 * @property string $file_extension
 * @property string $file_name
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property bool $is_deletable
 * @property User $user
 */
class File extends Model
{
    use HasFactory;

    const ZIP = ['zip'];
    const IMAGE = ['png', 'jpg', 'gif'];
    const JAR = ['jar'];

    protected $fillable = [
        'user_id',
        'file_size',
        'file_extension',
        'file_name',
        'is_deletable',
    ];

    /**
     * Return the user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get image path
     *
     * @return string
     */
    public function getPath(): string
    {
        return url("storage/images/$this->file_name");
    }

}
