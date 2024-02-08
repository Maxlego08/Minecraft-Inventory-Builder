import Slot from "./Slot";

const Inventory = ({invetory}) => {

    // @ts-ignore
    const slots = Array.from({length: invetory.size});

    return (
        <div className="inventory inventory-builder-center">
            <div className="inventory-content">
                <div className="inventory-content-header">
                    <span className="inventory-name" id="inventory-display-name">{invetory.name}</span>
                    <div className="inventory-content-header-actions">
                        <i className={"bi bi-floppy"}/>
                        <i className={"bi bi-trash"}/>
                    </div>
                </div>
                <div className="slotSpace" id="slots">
                    {slots.map((_, i) => (
                        <Slot key={i} id={i}></Slot>
                    ))}
                </div>
            </div>
        </div>
    )
}

export default Inventory
