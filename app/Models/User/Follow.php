<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    protected $fillable = ['follower_id', 'followed_id'];

    protected $table = 'user_follows';

    // Relation avec l'utilisateur qui suit
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Relation avec l'utilisateur suivi
    public function followed(): BelongsTo
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
