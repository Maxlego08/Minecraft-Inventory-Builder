import {useRef} from "react";
import Tooltip from "../utils/Tooltip";

const Item = ({item, onItemClick}) => {
    const itemRef = useRef(null);

    return (
        <div
            ref={itemRef}
            className={'item'}
            onClick={(event) => onItemClick(event, item)}
        >
            <i id={`item-${item.id}`} className={`icon-minecraft ${item.css}`}></i>
            <Tooltip item={item} itemRef={itemRef}/>
        </div>
    );
};

export default Item;
