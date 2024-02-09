import Slot from "./Slot";
import InventoryConfiguration from "./configuration/InventoryConfiguration";
import minecraftColor from "../../services/minecraftColor";
import DOMPurify from 'dompurify';

const Inventory = ({inventory, updateInventory, inventoryContent, handleSlotClick, handleSlotDoubleClick}) => {

    // @ts-ignore
    const slots = Array.from({length: inventory.size});

    const processedName = inventory.name ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventory.name)) : 'Inventory';

    const toggleAnimation = () => {
        const element = document.getElementById('saving-text');

        // Si l'élément est déjà visible, nous lançons l'animation de sortie
        if (element.classList.contains('animate-in')) {
            element.innerHTML = 'Sauvegarde terminé ! <i class="bi bi-check2-circle text-success ms-2"></i>'
            setTimeout(() => {
                element.classList.remove('animate-in');
                element.classList.add('animate-out');
            }, 1000)
        } else { // Sinon, nous lançons l'animation d'entrée
            element.classList.remove('animate-out');
            element.classList.add('animate-in');
        }
    }

    // Idée
    // Avoir plusieurs boutons en haut, dont un pour "lock" la page et retirer la possibilité de scroll, ainsi la page est fix et reste bien visible

    return (
        <div className={"inventory-builder-center"}>
            <div className={"inventory-builder-center-inventory inventory"}>
                <div className="inventory-content">
                    <div className="inventory-content-header">
                        <span className="inventory-name" id="inventory-display-name"
                              dangerouslySetInnerHTML={{__html: processedName}}></span>
                    </div>
                    <div className="slotSpace" id="slots">
                        {slots.map((_, i) => (
                            <Slot key={i} id={i} currentItem={inventoryContent.slots[i]}
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
