import Tooltip from "./utils/Tooltip";
import {useRef} from "react";
import api from '../../services/api'

const Slot = ({id, currentItem, handleSlotClick, handleSlotDoubleClick, currentSelectSlot, selectSlots}) => {

    const itemRef = useRef(null);
    const isSelect = currentSelectSlot == id || selectSlots.includes(id)

    console.log(currentItem)

    return (
        <div id={`slot-${id}`} className={`slot ${isSelect ? 'slot-select' : ''}`}
             onClick={event => handleSlotClick(event, id)}
             onContextMenu={event => handleSlotDoubleClick(event, id, false)}
             data-slot={id}>
            {currentItem.content != null && (
                <div ref={itemRef} className={'item'} data-slot={id}>
                    {currentItem.button.head && currentItem.content?.material === 'PLAYER_HEAD' ? (
                        <img className={'icon-minecraft'} src={api.getHeadUrl(currentItem.button.head.image_name)} alt={currentItem.button.head.name}/>
                    ) : (
                        <i id={`item-slot-${currentItem.content.id}`} data-slot={id}
                           className={`icon-minecraft ${currentItem.content.css}`}></i>
                    )
                    }
                    {currentItem.button.amount > 1 && (
                        <div id={`item-slot-number-${currentItem.content.id}`} data-slot={id}
                             className={'number'}>{currentItem.button.amount}</div>
                    )}
                    <Tooltip item={currentItem.content} button={currentItem.button} itemRef={itemRef}/>
                </div>
            )}
        </div>
    )

}

export default Slot
