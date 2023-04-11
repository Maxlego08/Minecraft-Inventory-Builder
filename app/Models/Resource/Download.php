<?php

namespace App\Models\Resource;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User $user
 * @property Version $version
 * @method static Download create(array $values)
 */
class Download extends Model
{
    use HasFactory;

    protected $table = "resource_downloads";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version_id',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class, 'version_id');
    }

    /**
     * @param Version $version
     * @param User $user
     * @return Download|null
     */
    public static function hasAlreadyDownload(Version $version, User $user): ?Download
    {
        return Download::where('user_id', $user->id)->where('version_id', $version->id)->first();
    }
}
