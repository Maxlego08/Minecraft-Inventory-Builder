import DisplayName from "./DisplayName";
import Lore from "./Lore";

const ItemStackConfiguration = ({inventoryContent, updateButton}) => {

    const handleChange = (event) => {
        const { name, value, type, checked } = event.target;

        const newValue = type === 'checkbox' ? checked : value;

        const updatedButton = {
            ...inventoryContent.slots[inventoryContent.currentSlot].button,
            [name]: newValue,
        };

        updateButton(inventoryContent.currentSlot, updatedButton);
    };


    return (
        <div className={'configurations-itemstack'}>

            {inventoryContent.currentSlot >= 0 ? (
                <div className={'p-2'}>
                    <DisplayName handleChange={handleChange} displayName={inventoryContent.slots[inventoryContent.currentSlot].button.display_name} />
                    <Lore handleChange={handleChange} lore={inventoryContent.slots[inventoryContent.currentSlot].button.lore} />
                </div>
            ) : (
                <div className={'d-flex justify-content-center align-items-center h-100'}>Please select an item</div>
            )}

        </div>
    )

}

export default ItemStackConfiguration
