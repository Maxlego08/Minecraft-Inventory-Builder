<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 */
interface Likeable
{
    public function likes(): MorphMany;

    public function getContentName(): string;

    public function getCacheName(): string;
}
