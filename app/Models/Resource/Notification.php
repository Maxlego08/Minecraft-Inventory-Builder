<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "resource_notifications";

    protected $fillable = ['user_id', 'resource_id', 'unsubscribe', 'enable_alert', 'enable_email'];
}
