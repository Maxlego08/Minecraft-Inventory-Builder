<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $slot
 * @property Item $item
 * @property int $amount
 * @property string $display_name
 * @property string $lore
 * @property int $model_id
 * @property boolean $glow
 * @property boolean $is_permanent
 * @property boolean $close_inventory
 * @property boolean $refresh_on_click
 * @property boolean $update_on_click
 * @property boolean $update
 */
class InventoryButton extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'inventory_id',
        'else_button_id',
        'type_id',
        'item_id',
        'slot',
        'messages',
        'commands',
        'page',
        'is_permanent',
        'close_inventory',
        'refresh_on_click',
        'update_on_click',
        'update',
        'amount',
        'display_name',
        'lore',
        'data',
        'glow',
        'model_id',
        'sound',
        'pitch',
        'volume',
    ];

    /**
     * Returns the inventory where the button is located
     *
     * @return BelongsTo
     */
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    /**
     * Returns the item used by the button
     *
     * @return BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

}
