<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment\Gift;
use App\Models\Payment\GiftHistory;
use App\Models\Resource\Resource;
use App\Models\User;

class GiftController extends Controller
{

    /**
     * Vérifier si le code est valide
     *
     * @param string $code
     * @param string $contentType
     * @param int $contentId
     * @param User $user
     * @return string
     */
    public function verify(string $code, string $contentType, int $contentId, User $user)
    {

        $gift = Gift::where('code', $code)->first();

        // Si le gift.js est null, on ne fait rien
        if ($gift === null) abort(404, 'Gift not found');

        // Si le gift.js n'est pas actif, on ne fait rien
        if (!$gift->active) abort(404, 'Gift is not active');

        // Si la resource n'est pas la bonne, on ne fait rien
        if ($gift->giftable_id != $contentId) abort(404, 'Gift is not for this content');

        // Si le type n'est pas le bon, alors on ne fait rien
        if ($gift->giftable_type != $contentType) abort(404, 'Gift is not for this type');

        // Si le nombre d'utilisations a été atteint, on ne fait rien
        if ($gift->used >= $gift->max_use) abort(404, 'Gift is already used');

        // Si l'utilisateur a déjà utilisé le gift.js, on ne fait rien
        if (!GiftHistory::canUse($gift, $user)) abort(404, 'Gift is already used by the used');

        // Sinon, le gift.js est valide
        return json_encode([
            'reduction' => $gift->reduction,
        ]);
    }
}
