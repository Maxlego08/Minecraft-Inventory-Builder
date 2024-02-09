import Slot from "./Slot";
import InventoryConfiguration from "./configuration/InventoryConfiguration";
import minecraftColor from "../../services/minecraftColor";
import DOMPurify from 'dompurify';

const Inventory = ({inventory, setInventory, inventoryContent, handleSlotClick, handleSlotDoubleClick}) => {

    // @ts-ignore
    const slots = Array.from({length: inventory.size});

    const processedName = inventory.name ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventory.name)) : 'Inventory';

    // Idée
    // Avoir plusieurs boutons en haut, dont un pour "lock" la page et retirer la possibilité de scroll, ainsi la page est fix et reste bien visible

    return (
        <div className={"inventory-builder-center"}>
            <div className={"inventory-builder-center-inventory inventory"}>
                <div className="inventory-content">
                    <div className="inventory-content-header">
                        <span className="inventory-name" id="inventory-display-name" dangerouslySetInnerHTML={{__html: processedName}}></span>
                        <div className="inventory-content-header-actions">
                            <i className={"bi bi-floppy"}/>
                            <i className={"bi bi-trash"}/>
                        </div>
                    </div>
                    <div className="slotSpace" id="slots">
                        {slots.map((_, i) => (
                            <Slot key={i} id={i} currentItem={inventoryContent.slots[i]}
                                  handleSlotClick={handleSlotClick} handleSlotDoubleClick={handleSlotDoubleClick}/>
                        ))}
                    </div>
                </div>
            </div>
            <InventoryConfiguration inventory={inventory} setInventory={setInventory}/>
        </div>
    )
}

export default Inventory
