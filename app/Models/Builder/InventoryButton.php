<?php

namespace App\Models\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slot
 * @property Item $item
 * @property int $amount
 * @property int $page
 * @property string $display_name
 * @property string $lore
 * @property int $model_id
 * @property boolean $glow
 * @property boolean $is_permanent
 * @property boolean $close_inventory
 * @property boolean $refresh_on_click
 * @property boolean $update_on_click
 * @property boolean $update
 * @property string $button_data
 * @property ButtonType $buttonType
 * @property Head $head
 * @method static InventoryButton[] all()
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
        'head_id',
        'slot',
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
        'button_data',
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

    /**
     * Returns the item used by the button
     *
     * @return BelongsTo
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(Head::class, 'head_id');
    }

    /**
     * Returns the button actions
     *
     * @return HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(InventoryButtonAction::class);
    }

    /**
     * Returns the item used by the button
     *
     * @return BelongsTo
     */
    public function buttonType(): BelongsTo
    {
        return $this->belongsTo(ButtonType::class, 'type_id');
    }

}
