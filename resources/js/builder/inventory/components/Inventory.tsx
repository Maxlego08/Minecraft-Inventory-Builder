import Slot from "./Slot";
import InventoryConfiguration from "./configuration/InventoryConfiguration";
import minecraftColor from "../../services/minecraftColor";
import DOMPurify from 'dompurify';
import HeaderInformation from "./configuration/HeaderInformation";

const Inventory = ({
                       inventory,
                       updateInventory,
                       inventoryContent,
                       handleSlotClick,
                       handleSlotDoubleClick,
                       needToUpdate,
                       saveData,
                       selectSlots,
                       page,
                       setPage,
                       maxPage
                   }) => {

    // @ts-ignore
    const slots = Array.from({length: inventory.size});

    const processedName = inventory.name ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventory.name)) : 'Inventory';

    const findButtonAt = (slot) => {
        return inventoryContent.slots.find(button => button.button.slot == slot && button.button.page == page)
    }

    return (<div className={"inventory-builder-center"}>
        <HeaderInformation needToUpdate={needToUpdate} saveData={saveData} inventoryId={inventory.id}/>
        <div className={"inventory-builder-center-inventory inventory"}>
            <div className="inventory-content">
                <div className="inventory-content-header">
                        <span className="inventory-name" id="inventory-display-name"
                              dangerouslySetInnerHTML={{__html: processedName}}></span>
                </div>
                <div className="slotSpace" id="slots">
                    {slots.map((_, i) => (<Slot key={i} id={i} currentItem={findButtonAt(i)}
                                                selectSlots={selectSlots}
                                                currentSelectSlot={inventoryContent.currentSlot}
                                                handleSlotClick={handleSlotClick}
                                                handleSlotDoubleClick={handleSlotDoubleClick}/>))}
                </div>
            </div>
        </div>
        <InventoryConfiguration inventory={inventory} updateInventory={updateInventory} page={page}
                                setPage={setPage} maxPage={maxPage}/>
    </div>)
}

export default Inventory
