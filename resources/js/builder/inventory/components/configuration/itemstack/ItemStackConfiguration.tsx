import DisplayName from "./DisplayName";
import Lore from "./Lore";
import Amount from "./Amount";
import Glow from "./Glow";
import ModelId from "./ModelId";

const ItemStackConfiguration = ({inventoryContent, updateButton}) => {

    const handleChange = (event) => {
        const { name, value, type, checked, min, max } = event.target;

        let newValue = type === 'checkbox' ? checked : value;

        if (type === 'number' || type === 'range') {
            const numericValue = parseFloat(newValue);
            const minValue = parseFloat(min);
            const maxValue = parseFloat(max);

            if (!isNaN(numericValue)) {
                if (!isNaN(minValue) && numericValue < minValue) {
                    newValue = minValue;
                } else if (!isNaN(maxValue) && numericValue > maxValue) {
                    newValue = maxValue;
                } else {
                    newValue = numericValue;
                }
            }
        }

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
                    <Amount handleChange={handleChange} amount={inventoryContent.slots[inventoryContent.currentSlot].button.amount} />
                    <Glow handleChange={handleChange} currentSlot={inventoryContent.slots[inventoryContent.currentSlot]} />
                    <ModelId handleChange={handleChange} currentSlot={inventoryContent.slots[inventoryContent.currentSlot]} />
                </div>
            ) : (
                <div className={'d-flex justify-content-center align-items-center h-100'}>Please select an item</div>
            )}

        </div>
    )

}

export default ItemStackConfiguration
