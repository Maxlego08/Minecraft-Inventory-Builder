import Tooltip from "./utils/Tooltip";
import {useRef} from "react";

const Slot = ({id, currentItem, handleSlotClick, handleSlotDoubleClick}) => {

    const itemRef = useRef(null);

    return (
        <div id={`slot-${id}`} className="slot"
             onClick={event => handleSlotClick(event, id)}
             onDoubleClick={event => handleSlotDoubleClick(event, id, true)}
             onContextMenu={event => handleSlotDoubleClick(event, id, false)}
             data-slot={id}>
            {currentItem.content != null && (
                <div ref={itemRef} className={'item'} data-slot={id}>
                    <i id={`item-slot-${currentItem.content.id}`} data-slot={id} className={`icon-minecraft ${currentItem.content.css}`}></i>
                    <div id={`item-slot-number-${currentItem.content.id}`} data-slot={id} className={'number'}>{currentItem.amount}</div>
                    <Tooltip item={currentItem.content} itemRef={itemRef}/>
                </div>
            )}
        </div>
    )

}

export default Slot
