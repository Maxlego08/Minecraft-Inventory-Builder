import DOMPurify from 'dompurify';
import minecraftColor from "../../services/minecraftColor";

const Inventory = ({inventoryName, inventorySize}) => {

    const processedName = inventoryName ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventoryName)) : 'Inventory';

    return (
        <div className="inventory">
            <div className="inventory-content">
                <div className="inventory-content-header">
                    <span className="inventory-name" id="inventory-display-name" dangerouslySetInnerHTML={{ __html: processedName }}></span>
                    <div className="inventory-content-header-actions">
                        <i className="fas fa-save" id="inventory-save"></i>
                        <i className="fas fa-trash" id="inventory-clear"
                           title="{{ __('inventory.configurations.inventory.delete-info') }}"></i>
                    </div>
                </div>
                <div className="slotSpace" id="slots">
                    {Array.from({ length: inventorySize }, (_, index) => (
                        <div key={index} id={`slot-${index}`} className="slot"></div>
                    ))}
                </div>
            </div>
        </div>
    )

}

export default Inventory
