import DisplayName from "./DisplayName";
import Lore from "./Lore";
import Amount from "./Amount";
import Glow from "./Glow";
import ModelId from "./ModelId";
import Head from "./Head";

const ItemStackConfiguration = ({inventoryContent, updateButton, selectedSlots}) => {

    const slotsToUpdate = selectedSlots.length > 0 ? selectedSlots : [inventoryContent.currentSlot].filter(index => index >= 0);

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

        slotsToUpdate.forEach(slotIndex => {
            const updatedButton = {
                ...inventoryContent.slots[slotIndex].button,
                [name]: newValue,
            };

            updateButton(slotIndex, updatedButton);
        });
    };

    const setHead = (head) => {
        slotsToUpdate.forEach(slotIndex => {
            const updatedButton = {
                ...inventoryContent.slots[slotIndex].button,
                head,
                head_id: head?.id ?? null,
            };

            updateButton(slotIndex, updatedButton);
        });
    }

    let currentSlot = inventoryContent.slots[inventoryContent.currentSlot]

    return (
        <div className={'configurations-itemstack'}>

            {inventoryContent.currentSlot >= 0 ? (
                <div className={'p-2'}>
                    {currentSlot.content?.material === 'PLAYER_HEAD' && (
                        <Head key={currentSlot.button.id} handleChange={handleChange} currentSlot={currentSlot} updateHead={setHead} />
                    )}
                    <DisplayName handleChange={handleChange} displayName={currentSlot.button.display_name} />
                    <Lore handleChange={handleChange} lore={currentSlot.button.lore} />
                    <Amount handleChange={handleChange} amount={currentSlot.button.amount} />
                    <Glow handleChange={handleChange} currentSlot={currentSlot} />
                    <ModelId handleChange={handleChange} currentSlot={currentSlot} />
                </div>
            ) : (
                <div className={'d-flex justify-content-center align-items-center h-100'}>Please select an item</div>
            )}
        </div>
    )
}

export default ItemStackConfiguration
