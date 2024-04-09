import DOMPurify from 'dompurify';
import minecraftColor from "../../services/minecraftColor";

const Inventory = ({inventoryName, inventorySize}) => {

    const processedName = inventoryName ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(inventoryName)) : 'Inventory';

    const slots = [];
    for (let index = 0; index < inventorySize; index++) {
        slots.push(<div key={index} id={`slot-${index}`} className="slot"></div>)
    }

    return (<div className="inventory">
            <div className="inventory-content">
                <div className="inventory-content-header">
                    <span className="inventory-name" id="inventory-display-name"
                          dangerouslySetInnerHTML={{__html: processedName}}></span>
                </div>
                <div className="slotSpace" id="slots">
                    {slots}
                </div>
            </div>
        </div>)
}

export default Inventory
