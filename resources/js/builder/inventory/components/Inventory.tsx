import Slot from "./Slot";

const Inventory = ({inventory, inventoryContent, handleSlotClick, handleSlotDoubleClick}) => {

    // @ts-ignore
    const slots = Array.from({length: inventory.size});

    return (
        <div className="inventory inventory-builder-center">
            <div className="inventory-content">
                <div className="inventory-content-header">
                    <span className="inventory-name" id="inventory-display-name">{inventory.name}</span>
                    <div className="inventory-content-header-actions">
                        <i className={"bi bi-floppy"}/>
                        <i className={"bi bi-trash"}/>
                    </div>
                </div>
                <div className="slotSpace" id="slots">
                    {slots.map((_, i) => (
                        <Slot key={i} id={i} currentItem={inventoryContent.slots[i]} handleSlotClick={handleSlotClick} handleSlotDoubleClick={handleSlotDoubleClick}/>
                    ))}
                </div>
            </div>
        </div>
    )
}

export default Inventory
