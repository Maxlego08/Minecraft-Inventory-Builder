import {useCallback, useEffect, useState} from "react";
import Items from "./components/items/Items";
import Inventory from "./components/Inventory"
import slot from "./components/Slot";

const InventoryBuilder = () => {

    // @ts-ignore
    const [data, setData] = useState(window.Content || {});
    const [currentItem, setCurrentItem] = useState(null);
    const [currentCount, setCurrentCount] = useState(0);
    const [isShiftClick, setIsShiftClick] = useState(false);
    const [inventoryContent, setInventoryContent] = useState({
        // @ts-ignore
        slots: Array.from({length: 54}, (_, index) => ({
            id: index,
            content: null,
            amount: 1
        }))
    });

    useEffect(() => {

        // Attacher les écouteurs d'événements
        document.addEventListener('mousemove', onItemMove);
        document.addEventListener('wheel', onItemMove);
        document.addEventListener('keydown', handleKeyDown);
        document.addEventListener('keyup', handleKeyUp);

        // console.log(currentCount)
        updateCountElement();

        if (currentItem != null) {

            if (currentItem.event != null) {
                onItemMove(currentItem.event);
                setCurrentItem(current => ({
                    ...current,
                    event: null,
                }));
            }

            currentItem.clickElement.addEventListener('click', onCurrentElementClick);
        }

        // Fonction de nettoyage pour supprimer les écouteurs d'événements
        return () => {
            document.removeEventListener('mousemove', onItemMove);
            document.removeEventListener('wheel', onItemMove);
            document.removeEventListener('keydown', handleKeyDown);
            document.removeEventListener('keyup', handleKeyUp);

            if (currentItem != null) {
                currentItem.clickElement.removeEventListener('click', onCurrentElementClick);
            }
        };
    });

    const handleKeyDown = useCallback(event => {
        event = event || window.event;
        if (isKeyPress(event, ['Escape', 'Esc'], 27)) {
            deleteItem();
        }
        if (isKeyPress(event, ['Shift'], 16)) {
            setIsShiftClick(true);
        }
    }, [isShiftClick, currentItem]);

    const handleKeyUp = useCallback(event => {
        event = event || window.event;
        if (isKeyPress(event, ['Shift'], 16)) {
            setIsShiftClick(false);
        }
    }, [isShiftClick]);

    const isKeyPress = (event, keys, keyCode) => {
        return !!(keys.includes(event.key) || event.keyCode === keyCode);

    };

    const deleteItem = () => {

        if (currentItem == null) return

        if (document.body.contains(currentItem.clickElement)) {
            document.body.removeChild(currentItem.clickElement);
            setCurrentItem(null)
        }
    };

    const onItemClick = (event, item, amount = -1) => {
        event.preventDefault();

        if (currentItem != null) {
            deleteItem()
            return
        }

        let clickElement = document.createElement('div');
        let countElement = document.createElement('span');
        countElement.classList.add('mouse-item');

        let ghostItem = document.createElement('div')

        ghostItem.classList.add("icon-minecraft")
        ghostItem.classList.add(`${item.css}`)
        ghostItem.style.position = 'absolute';
        ghostItem.style.zIndex = '1000';

        let shiftX = clickElement.getBoundingClientRect().left + 15;
        let shiftY = clickElement.getBoundingClientRect().top + 15;
        clickElement.style.position = 'absolute';

        clickElement.append(ghostItem)
        clickElement.append(countElement);

        document.body.append(clickElement);

        setCurrentCount(amount === -1 ? (isShiftClick ? 64 : 1) : amount);

        setCurrentItem({
            event: event,
            target: ghostItem,
            item: item,
            clickElement: clickElement,
            countElement: countElement,
            shiftX: shiftX,
            shiftY: shiftY
        })
    }

    const onCurrentElementClick = useCallback(event => {

        event.preventDefault();

        if (currentItem == null) return

        let currentElement = getCurrentPointElement(event)
        if (currentItem.target === currentElement) {
            // When we add more items here, the more we will add to the number the more the site goes lag, I do not understand why
            // addCount(isShiftClick ? 64 : 1)
        } else {
            let elementId = currentElement.id
            if (elementId == null) return

            // @ts-ignore
            if (elementId.startsWith("item") && !elementId.startsWith("item-slot")) {
                deleteItem()
                // @ts-ignore
            } else if (elementId.startsWith("slot")) {

                let slotId = currentElement.getAttribute('data-slot')
                updateSlotContent(slotId, currentItem.item, currentCount)
                deleteItem()

            } else {

                // @ts-ignore
                if (elementId.startsWith("item-slot")) {
                    let elementSlot = currentElement.parentElement.parentElement
                    let slotId = elementSlot.getAttribute('data-slot')
                    handleSlotClick(event, slotId)
                }
            }
        }

    }, [currentItem, inventoryContent])

    const getCurrentPointElement = (event) => {
        let elements = document.elementsFromPoint(event.clientX, event.clientY)
        if (elements.length >= 3) return elements[2]
        return null;
    }

    const addCount = (count) => {
        setCount(currentCount + count)
    }

    const setCount = (count) => {
        if (count > 64) count = 64
        else if (count < 1) count = 1
        setCurrentCount(count)
    }

    const updateCountElement = () => {
        if (currentItem == null) return
        currentItem.countElement.innerText = `${currentCount}`;
    }

    const onItemMove = useCallback(event => {
        if (currentItem == null) return

        let x = event.pageX - currentItem.shiftX;
        let y = event.pageY - currentItem.shiftY;

        currentItem.clickElement.style.left = x + 'px';
        currentItem.clickElement.style.top = y + 'px';
    }, [currentItem])

    const updateSlotContent = (slotIndex, newContent, newAmount = 1) => {
        setInventoryContent(prevInventoryContent => {
            const newSlots = [...prevInventoryContent.slots];

            newSlots[slotIndex] = {...newSlots[slotIndex], content: newContent, amount: newAmount};

            return {...prevInventoryContent, slots: newSlots};
        });
    };

    const updateSlotAmount = (slotIndex, newAmount) => {
        setInventoryContent(prevInventoryContent => {
            const newSlots = [...prevInventoryContent.slots];

            newSlots[slotIndex] = {...newSlots[slotIndex], amount: newAmount};

            return {...prevInventoryContent, slots: newSlots};
        });
    };

    const handleSlotClick = (event, id) => {

        event.preventDefault()

        // If the current item is null, we can only take the content of the slot, if it exists
        if (currentItem == null) {
            let slot = inventoryContent.slots[id]

            if (slot.content == null) return

            updateSlotContent(id, null)
            onItemClick(event, slot.content, slot.amount)

            return
        }

        console.log(event)
        console.log(id)
    }

    return (
        <div className={'inventory-builder'}>
            <Items versions={data.versions} onItemClick={onItemClick}/>
            <Inventory inventory={data.inventory} inventoryContent={inventoryContent}
                       handleSlotClick={handleSlotClick}/>
            <div className="configurations">
            </div>
        </div>
    );
}

export default InventoryBuilder
