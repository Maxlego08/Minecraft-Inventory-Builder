<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property double $price
 */
class NameColor extends Model
{
    use HasFactory;

    protected $table = "user_name_colors";

    protected $fillable = ['code', 'price'];


    /**
     * Retourne la traduction du name color
     *
     * @return string
     */
    public function translation(): string
    {
        return __("colors.$this->code");
    }

}
