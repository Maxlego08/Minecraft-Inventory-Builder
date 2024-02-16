import {useCallback, useEffect, useState} from "react";
import Items from "./components/items/Items";
import Inventory from "./components/Inventory"
import slot from "./components/Slot";
import api from "../services/api"
import ButtonConfiguration from "./components/configuration/button/ButtonConfiguration";
import ItemStackConfiguration from "./components/configuration/itemstack/ItemStackConfiguration";

const InventoryBuilder = () => {

    const findButton = (index) => {
        return inventory.buttons.find(button => button.slot == index) || null;
    }

    // @ts-ignore
    const [data, setData] = useState(window.Content || {});
    const [inventory, setInventory] = useState(data.inventory || {});
    const [currentItem, setCurrentItem] = useState(null);
    const [currentCount, setCurrentCount] = useState(0);
    const [isShiftClick, setIsShiftClick] = useState(false);
    const [needToUpdate, setNeedToUpdate] = useState(false);
    const [slots, setSlots] = useState([]);
    const [inventoryContent, setInventoryContent] = useState({
        currentSlot: -1,
        // @ts-ignore
        slots: Array.from({length: 54}, (_, index) => {
            let button = findButton(index)
            return ({
                id: index,
                content: button?.item ?? null,
                button: button ?? {
                    model_id: 0,
                    amount: 0,
                    display_name: null,
                    lore: null,
                    messages: null,
                    name: `btn-${index}`,
                    volume: 1.0,
                    pitch: 1.0,
                    sound: '',
                    glow: false
                }
            })
        })
    });

    useEffect(() => {
        const intervalId = setInterval(() => {
            saveData();
        }, 1000 * 30); // 30 seconds

        return () => clearInterval(intervalId);
    });

    useEffect(() => {

        const handleBeforeUnload = (e) => {
            if (needToUpdate) {
                const message = "You have unsaved changes. Are you sure you want to leave?";
                e.returnValue = message;
                return message;
            }
        };

        document.addEventListener('mousemove', onItemMove);
        document.addEventListener('wheel', onItemMove);
        document.addEventListener('keydown', handleKeyDown);
        document.addEventListener('keyup', handleKeyUp);
        window.addEventListener('beforeunload', handleBeforeUnload);

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
            currentItem.clickElement.addEventListener('contextmenu', onCurrentElementContextClick);
        }

        return () => {
            document.removeEventListener('mousemove', onItemMove);
            document.removeEventListener('wheel', onItemMove);
            document.removeEventListener('keydown', handleKeyDown);
            document.removeEventListener('keyup', handleKeyUp);
            window.removeEventListener('beforeunload', handleBeforeUnload);

            if (currentItem != null) {
                currentItem.clickElement.removeEventListener('click', onCurrentElementClick);
                currentItem.clickElement.removeEventListener('contextmenu', onCurrentElementContextClick);
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

    const removeOne = () => {

        if (currentItem == null) return

        let newAmount = currentCount - 1
        if (newAmount <= 0) {
            deleteItem()
        } else {
            setCurrentCount(newAmount)
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
                } else deleteItem()
            }
        }

    }, [currentItem, inventoryContent])

    const onCurrentElementContextClick = useCallback(event => {

        event.preventDefault();

        if (currentItem == null) return

        let currentElement = getCurrentPointElement(event)

        let elementId = currentElement.id
        if (elementId == null) return

        // @ts-ignore
        // If the player clicks on a slot
        if (elementId.startsWith("slot") || elementId.startsWith("item-slot")) {

            // We will retrieve the slot ID currently
            let slotId = currentElement.getAttribute('data-slot')

            // We will calculate the new number of elements
            let newAmount = inventoryContent.slots[slotId].button.amount + 1
            if (newAmount > 64) return

            updateSlotContent(slotId, currentItem.item, newAmount)
            removeOne()
        }

    }, [inventoryContent, currentItem, currentCount])

    const getCurrentPointElement = (event) => {
        let elements = document.elementsFromPoint(event.clientX, event.clientY)
        if (elements.length >= 3) return elements[2]
        return null;
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
        setNeedToUpdate(true)
        setInventoryContent(prevInventoryContent => {
            const newSlots = [...prevInventoryContent.slots];

            const updatedButton = {
                ...inventoryContent.slots[slotIndex].button,
                amount: newAmount,
            };

            newSlots[slotIndex] = {...newSlots[slotIndex], content: newContent, button: updatedButton};

            return {...prevInventoryContent, slots: newSlots, currentSlot: slotIndex};
        });
    };

    const updateSlotAmount = (slotIndex, newAmount) => {
        setNeedToUpdate(true)
        setInventoryContent(prevInventoryContent => {
            const newSlots = [...prevInventoryContent.slots];

            const updatedButton = {
                ...inventoryContent.slots[slotIndex].button,
                amount: newAmount,
            };

            newSlots[slotIndex] = {...newSlots[slotIndex], button: updatedButton};

            return {...prevInventoryContent, slots: newSlots, currentSlot: slotIndex};
        });
    };

    const updateButton = (slotIndex, button) => {
        setNeedToUpdate(true)
        setInventoryContent(prevInventoryContent => {
            const newSlots = [...prevInventoryContent.slots];

            newSlots[slotIndex] = {...newSlots[slotIndex], button: button};

            return {...prevInventoryContent, slots: newSlots};
        });
    };

    const selectSlot = (slotIndex) => {
        setInventoryContent(prevInventoryContent => {
            return {...prevInventoryContent, currentSlot: slotIndex};
        });
    };

    const handleSlotClick = (event, id) => {

        event.preventDefault()

        // Manage the selection of multiple slots
        if (isShiftClick) {
            // @ts-ignore
            if (slots.includes(id)) {
                removeSlot(id)
            } else {
                if (slots.length === 0) selectSlot(id)
                addSlot(id)
            }
            return
        }

        // Select the slot before you can move the item.
        if ((inventoryContent.currentSlot == null || inventoryContent.currentSlot != id) && currentItem == null) {
            selectSlot(id)
            setSlots([])
            return
        }

        let slot = inventoryContent.slots[id]

        // If the current item is null, we can only take the content of the slot, if it exists
        if (currentItem == null) {

            if (slot.content == null) return

            updateSlotContent(id, null, 0)
            onItemClick(event, slot.content, slot.button.amount)

            return
        }

        // If the item in the slot is not null et que l’article actuel est le même que l’article actuel
        if (slot.content != null && slot.content.id == currentItem.item.id) {
            // We will add the item to the one already present, except that the number exceeds the maxStackSize or 64

            let newAmount = slot.button.amount + currentCount
            // If the number is greater than 64, then the number must be reduced
            if (newAmount > 64) {
                // We will calculate the new number of items that the player has in the hand
                let newCurrentAmount = newAmount - currentCount
                setCurrentCount(newCurrentAmount)
                // We will set the new number to 64
                newAmount = 64
            } else {
                // Otherwise we will delete the item
                deleteItem()
            }

            updateSlotAmount(id, newAmount)
        }
    }

    const handleSlotDoubleClick = (event, id, isMiddleClick = true) => {

        event.preventDefault()

        if (!isMiddleClick) {

            let slot = inventoryContent.slots[id]
            let currentAmount = slot.button.amount
            if (currentAmount == 1) {

                updateSlotContent(id, null, 0)
                onItemClick(event, slot.content, 1)

                return
            }

            let newAmount = parseInt(String(currentAmount / 2))
            updateSlotAmount(id, currentAmount - newAmount)
            onItemClick(event, slot.content, newAmount)
            return
        }
    }

    const updateInventory = (inventory) => {
        setInventory(inventory)
        setNeedToUpdate(true)
    }

    const saveData = () => {
        if (!needToUpdate) return;

        setNeedToUpdate(false);

        const toggleAnimation = (add, remove) => {

            const element = document.getElementById('saving-text');
            if (element) {
                element.classList.add(add);
                element.classList.remove(remove);
            }
        };

        toggleAnimation('animate-in', 'animate-out');

        const formData = new FormData();

        inventoryContent.slots.map((slot, index) => {
            if (slot.content != null) {
                formData.append(`slot[${index}]item_id`, slot.content.id);
                formData.append(`slot[${index}]amount`, slot.button.amount);
                formData.append(`slot[${index}]slot`, slot.id);
                formData.append(`slot[${index}]name`, slot.button.name);
                formData.append(`slot[${index}]is_permanent`, slot.button.is_permanent);
                formData.append(`slot[${index}]close_inventory`, slot.button.close_inventory);
                formData.append(`slot[${index}]refresh_on_click`, slot.button.refresh_on_click);
                formData.append(`slot[${index}]update_on_click`, slot.button.update_on_click);
                formData.append(`slot[${index}]update`, slot.button.update);
                formData.append(`slot[${index}]glow`, slot.button.glow);
                formData.append(`slot[${index}]model_id`, slot.button.model_id);
                formData.append(`slot[${index}]volume`, slot.button.volume);
                formData.append(`slot[${index}]pitch`, slot.button.pitch);
                formData.append(`slot[${index}]sound`, slot.button.sound);
                formData.append(`slot[${index}]messages`, slot.button.messages);
                if (slot.button?.display_name) formData.append(`slot[${index}]display_name`, slot.button.display_name);
                if (slot.button?.lore) formData.append(`slot[${index}]lore`, slot.button.lore);
            }
        });

        ['name', 'size', 'file_name', 'update_interval', 'clear_inventory'].forEach(prop => {
            if (inventory[prop] !== undefined) {
                formData.append(prop, inventory[prop]);
            }
        });

        setTimeout(() => {
            const handleResponse = () => {
                toggleAnimation('animate-out', 'animate-in');
            };

            api.updateInventory(formData, inventory.id).then(handleResponse).catch(handleResponse);
        }, 1000);
    };

    const addSlot = (element) => {
        setSlots([...slots, element]);
    };

    const removeSlot = (index) => {
        setSlots(slots.filter((i, _) => i != index));
    };

    return (
        <div className={'inventory-builder'}>
            <div id={"saving-text"} className="text-animation">
                <div className={'me-2'}>Saving</div>
                <div className="spinner-border spinner-border-sm" role="status">
                    <span className="visually-hidden"></span>
                </div>
            </div>
            <Items versions={data.versions} onItemClick={onItemClick}/>
            <Inventory inventory={inventory} updateInventory={updateInventory} inventoryContent={inventoryContent}
                       needToUpdate={needToUpdate} saveData={saveData} selectSlots={slots}
                       handleSlotClick={handleSlotClick} handleSlotDoubleClick={handleSlotDoubleClick}/>
            <div className="configurations">
                <ItemStackConfiguration inventoryContent={inventoryContent} updateButton={updateButton}
                                        selectedSlots={slots}/>
                <ButtonConfiguration inventoryContent={inventoryContent} updateButton={updateButton}
                                     selectedSlots={slots} buttonTypes={data.buttonTypes} sounds={data.sounds}/>
            </div>
        </div>
    );
}

export default InventoryBuilder
