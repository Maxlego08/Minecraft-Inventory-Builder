import {useEffect, useState} from "react";
import Items from "./components/items/Items";

const Inventory = () => {

    const [data, setData] = useState(window.Content || {});
    const [currentItem, setCurrentItem] = useState(null);
    const [currentCount, setCurrentCount] = useState(1);
    const [isShiftClick, setIsShiftClick] = useState(false);

    useEffect(() => {
        document.addEventListener('mousemove', event => onItemMove(event));
        document.addEventListener('wheel', event => onItemMove(event));
        document.addEventListener('keydown', event => handleKeyDown(event));
        document.addEventListener('keyup', event => handleKeyUp(event));

        console.log(currentCount)

        updateCountElement()

        if (currentItem != null){
            currentItem.clickElement.addEventListener('click', event => onCurrentElementClick(event))
        }
    })

    const handleKeyDown = (event) => {
        event = event || window.event;
        if (isKeyPress(event, ['Escape', 'Esc'], 27)) {
            deleteItem();
        }
        if (isKeyPress(event, ['Shift'], 16)) {
            setIsShiftClick(true);
        }
    };

    const handleKeyUp = (event) => {
        event = event || window.event;
        if (isKeyPress(event, ['Shift'], 16)) {
            setIsShiftClick(false);
        }
    };

    const isKeyPress = (event, keys, keyCode) => {
        return !!(keys.includes(event.key) || event.keyCode === keyCode);

    };

    const deleteItem = () => {
        if (currentItem == null) return
        document.body.removeChild(currentItem.clickElement);

        setCurrentItem(null)
    };

    const onItemClick = (event, item, amount = -1) => {
        event.preventDefault();

        if (currentItem != null) {
            addCount(amount === -1 ? (isShiftClick ? 64 : 1) : amount);
            return
        }

        let element = event.target

        let clickElement = document.createElement('div');
        let countElement = document.createElement('span');
        countElement.classList.add('mouse-item');

        let ghostItem = element.cloneNode(true);

        ghostItem.style.position = 'absolute';
        ghostItem.style.zIndex = '1000';

        let shiftX = clickElement.getBoundingClientRect().left + 15;
        let shiftY = clickElement.getBoundingClientRect().top + 15;
        clickElement.style.position = 'absolute';

        clickElement.append(ghostItem)
        clickElement.append(countElement);

        document.body.append(clickElement);

        setCurrentItem({
            event: event,
            target: element,
            item: item,
            clickElement: clickElement,
            countElement: countElement,
            shiftX: shiftX,
            shiftY: shiftY
        })
    }

    const onCurrentElementClick = (event) => {

        if (currentItem == null) return

        let currentElement = getCurrentPointElement(event)
        if (currentItem.target === currentElement) {
            addCount(isShiftClick ? 64 : 1)
        }
    }

    const getCurrentPointElement = (event) => {
        let elements = document.elementsFromPoint(event.clientX, event.clientY)
        if (elements.length >= 3) return elements[2]
        return null;
    }

    const addCount = (count) => {
        setCurrentCount(count)
        updateCountElement();
    }

    const setCount = (count) => {
        setCurrentCount(count)
        updateCountElement();
    }

    const updateCountElement = () => {
        if (currentItem == null) return

        // ToDo, update with max stack size
        setCurrentCount(currentCount > 64 ? 64 : currentCount < 1 ? 1 : currentCount);
        currentItem.countElement.innerText = `${currentCount}`;
    }

    const onItemMove = (event) => {
        if (currentItem == null) return

        let x = event.pageX - currentItem.shiftX;
        let y = event.pageY - currentItem.shiftY;

        currentItem.clickElement.style.left = x + 'px';
        currentItem.clickElement.style.top = y + 'px';
    }

    return (
        <div className={'inventory-builder'}>
            <Items versions={data.versions} onItemClick={onItemClick}/>
        </div>
    );
}

export default Inventory
