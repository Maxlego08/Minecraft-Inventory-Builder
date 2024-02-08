import Tooltip from "./utils/Tooltip";
import {useRef} from "react";

const Slot = ({id, currentItem, handleSlotClick}) => {

    const itemRef = useRef(null);

    return (
        <div id={`slot-${id}`} className="slot" onClick={event => handleSlotClick(event, id)} data-slot={id}>
            {currentItem.content != null && (
                <div ref={itemRef} className={'item'}>
                    <i id={`item-slot-${currentItem.content.id}`} className={`icon-minecraft ${currentItem.content.css}`}></i>
                    <div id={`item-slot-number-${currentItem.content.id}`} className={'number'}>{currentItem.amount}</div>
                    <Tooltip item={currentItem.content} itemRef={itemRef}/>
                </div>
            )}
        </div>
    )

}

export default Slot
