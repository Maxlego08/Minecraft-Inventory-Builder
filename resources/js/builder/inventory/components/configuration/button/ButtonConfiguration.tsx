import SearchableSelect from "../../utils/SearchableSelect";
import {Form} from "react-bootstrap";
import ButtonName from "./ButtonName";
import IsPermanent from "./IsPermanent";
import CloseInventory from "./CloseInventory";
import RefreshOnClick from "./RefreshOnClick";
import UpdateOnClick from "./UpdateOnClick";
import Update from "./Update";
import Sound from "./Sound";
import Messages from "./Messages";

const ButtonConfiguration = ({inventoryContent, buttonTypes, updateButton, selectedSlots, sounds}) => {

    const slotsToUpdate = selectedSlots.length > 0 ? selectedSlots : [inventoryContent.currentSlot].filter(index => index >= 0);
    let currentSlot = inventoryContent.currentSlot >= 0 ? inventoryContent.slots[inventoryContent.currentSlot] : null;

    const handleChange = (event) => {
        const {name, value, type, checked, min, max} = event.target;

        let newValue = type === 'checkbox' ? checked : value;

        if (type === 'number' || type === 'range') {
            const numericValue = parseFloat(newValue);
            const minValue = parseFloat(min);
            const maxValue = parseFloat(max);

            if (!isNaN(numericValue)) {
                if (!isNaN(minValue) && numericValue < minValue) {
                    newValue = minValue;
                } else if (!isNaN(maxValue) && numericValue > maxValue) {
                    newValue = maxValue;
                } else {
                    newValue = numericValue;
                }
            }
        }

        slotsToUpdate.forEach(slotIndex => {
            const updatedButton = {
                ...inventoryContent.slots[slotIndex].button,
                [name]: newValue,
            };

            updateButton(slotIndex, updatedButton);
        });
    };

    return inventoryContent.currentSlot >= 0 ? (
        <div className={'configurations-button'}>
            <div className={'configurations-button-top p-2'}>
                <div className={'configurations-button-header mb-2'}>
                    General configuration
                </div>
                <div className={'row mb-3'}>
                    <div className={'col-2'}>
                        <Form.Group>
                            <Form.Label>Slot</Form.Label>
                            <Form.Control
                                disabled={true}
                                value={inventoryContent.currentSlot}
                                className={'rounded-1 disabled'}
                            />
                        </Form.Group>
                    </div>
                    <div className={'col-10'}>
                        <ButtonName currentSlot={currentSlot} handleChange={handleChange}/>
                    </div>
                </div>
                <IsPermanent currentSlot={currentSlot} handleChange={handleChange}/>
                <CloseInventory currentSlot={currentSlot} handleChange={handleChange}/>
                <RefreshOnClick currentSlot={currentSlot} handleChange={handleChange}/>
                <UpdateOnClick currentSlot={currentSlot} handleChange={handleChange}/>
                <Update currentSlot={currentSlot} handleChange={handleChange}/>
                <Sound sounds={sounds} currentSlot={currentSlot} handleChange={handleChange}/>
                <Messages currentSlot={currentSlot} handleChange={handleChange}/>
            </div>
            <div className={'configurations-button-bottom p-2'}>
                <div className={'configurations-button-header mb-2'}>
                    Specific configuration
                </div>
                <SearchableSelect key={'button_type'} options={buttonTypes} handleChange={handleChange} name={'bouton_type'}/>
            </div>
        </div>
    ) : (
        <div className={'configurations-button'}>
            <div className={'configurations-button-top p-2'}>
                <div className={'d-flex justify-content-center align-items-center h-100'}>Please select an item
                </div>
            </div>
            <div className={'configurations-button-bottom p-2'}>
                <div className={'d-flex justify-content-center align-items-center h-100'}>Please select an item
                </div>
            </div>
        </div>
    )

}

export default ButtonConfiguration
