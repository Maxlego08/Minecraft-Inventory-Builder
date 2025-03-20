<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $data
 * @property ActionType $action
 */
class InventoryButtonAction extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_button_id', 'inventory_action_type_id', 'data'];

    public function action(): BelongsTo
    {
        return $this->belongsTo(ActionType::class, "inventory_action_type_id");
    }

}
