import {useRef, useState} from "react";
import Tooltip from "../utils/Tooltip";

const Item = ({ item }) => {
    const itemRef = useRef(null);

    return (
        <div
            ref={itemRef}
            className={'item'}
        >
            <i className={"icon-minecraft " + item.css}></i>
            <Tooltip item={item} itemRef={itemRef} />
        </div>
    );
};

export default Item;
