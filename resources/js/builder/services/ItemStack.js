class ItemStack {

    name;
    type;
    amount;
    lore;
    enchantments = [];
    flags = [];

    minecraft_name;

    /**
     *
     * @param type
     * @param minecraft_name
     */
    constructor(type, minecraft_name) {
        this.type = type;
        this.minecraft_name = minecraft_name;
    }

    /**
     * Permet d'ajouter un enchantement
     *
     * @param enchantment
     * @param level
     */
    addEnchant(enchantment, level) {
        this.enchantments.push({
            'enchantment': enchantment,
            'level': level,
        });
    }

}

export default ItemStack
