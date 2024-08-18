<?php

namespace App\Traits;

trait ReviewStarts
{

    protected function reviewScores($score): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($score >= $i) {
                $stars .= '<i class="bi bi-star-fill"></i>';
            } else if ($score >= ($i - 0.5)) {
                $stars .= '<i class="bi bi-star-half"></i>';
            } else {
                $stars .= '<i class="bi bi-star"></i>';
            }
        }
        return $stars;
    }

}
