import Tooltip from "./utils/Tooltip";
import {useRef} from "react";

const Slot = ({id, currentItem, handleSlotClick, handleSlotDoubleClick, currentSelectSlot}) => {

    const itemRef = useRef(null);

    return (
        <div id={`slot-${id}`} className={`slot ${currentSelectSlot == id ? 'slot-select' : ''}`}
             onClick={event => handleSlotClick(event, id)}
             onContextMenu={event => handleSlotDoubleClick(event, id, false)}
             data-slot={id}>
            {currentItem.content != null && (
                <div ref={itemRef} className={'item'} data-slot={id}>
                    <i id={`item-slot-${currentItem.content.id}`} data-slot={id} className={`icon-minecraft ${currentItem.content.css}`}></i>
                    <div id={`item-slot-number-${currentItem.content.id}`} data-slot={id} className={'number'}>{currentItem.amount}</div>
                    <Tooltip item={currentItem.content} button={currentItem.button} itemRef={itemRef}/>
                </div>
            )}
        </div>
    )

}

export default Slot
