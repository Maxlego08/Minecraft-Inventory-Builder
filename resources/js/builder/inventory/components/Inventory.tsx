import Slot from "./Slot";
import InventoryConfiguration from "./configuration/InventoryConfiguration";
import minecraftColor from "../../services/minecraftColor";
import DOMPurify from 'dompurify';
import HeaderInformation from "./configuration/HeaderInformation";

const Inventory = ({inventory, updateInventory, inventoryContent, handleSlotClick, handleSlotDoubleClick, needToUpdate, saveData}) => {

    // @ts-ignore
    const slots = Array.from({length: inventory.size});

    const processedName = inventory.name ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventory.name)) : 'Inventory';

    return (
        <div className={"inventory-builder-center"}>
            <HeaderInformation needToUpdate={needToUpdate} saveData={saveData} inventoryId={inventory.id}/>
            <div className={"inventory-builder-center-inventory inventory"}>
                <div className="inventory-content">
                    <div className="inventory-content-header">
                        <span className="inventory-name" id="inventory-display-name"
                              dangerouslySetInnerHTML={{__html: processedName}}></span>
                    </div>
                    <div className="slotSpace" id="slots">
                        {slots.map((_, i) => (
                            <Slot key={i} id={i} currentItem={inventoryContent.slots[i]} currentSelectSlot={inventoryContent.currentSlot}
                                  handleSlotClick={handleSlotClick} handleSlotDoubleClick={handleSlotDoubleClick}/>
                        ))}
                    </div>
                </div>
            </div>
            <InventoryConfiguration inventory={inventory} updateInventory={updateInventory}/>
        </div>
    )
}

export default Inventory
