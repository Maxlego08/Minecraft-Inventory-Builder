<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $total_size
 * @property int $size
 * @property int $max_resources
 * @property boolean $premium_resources
 * @property string $allow_files
 */
class UserRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_size',
        'size',
        'allow_files',
        'max_resources',
        'premium_resources',
    ];


    /**
     * Return the validator for an image
     *
     * @return string
     */
    public function getImageValidator(): string
    {
        return 'required|image|mimes:' . $this->allow_files . ',|max:' . ($this->size / 1000);
    }
}
