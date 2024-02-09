import {Form} from "react-bootstrap";
import {useState} from "react";

const InventoryConfiguration = ({inventory, setInventory}) => {

    const [error, setError] = useState('');

    const handleChange = (event) => {

        const {name, value, type, checked} = event.target;
        console.log(name)
        console.log(value)
        console.log(type)
        console.log(checked)
        setInventory(prevData => ({
            ...prevData,
            [name]: type === 'checkbox' ? checked : value
        }));

    }

    return (
        <div className={"inventory-builder-center-configuration p-3"}>

            <div className={"mb-3"}>
                <Form.Group className="mb-3">
                    <Form.Label>Inventory name</Form.Label>
                    <Form.Control
                        type="text"
                        name="name"
                        value={inventory.name}
                        onChange={handleChange}
                        className={'rounded-1'}
                        placeholder={'Inventory'}
                        isInvalid={!!error}
                    />
                    <Form.Control.Feedback type="invalid">
                        {error}
                    </Form.Control.Feedback>

                    <small className="form-text text-muted">
                        The name of the inventory that will be displayed. Please note that depending on your version
                        you have a character limit. You can use color and placeholders.
                    </small>

                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Size</Form.Label>
                    <Form.Select name="size" value={inventory.size} onChange={handleChange}
                                 className={'rounded-1'}>
                        <option value="9">9</option>
                        <option value="18">18</option>
                        <option value="27">27</option>
                        <option value="36">36</option>
                        <option value="45">45</option>
                        <option value="54">54</option>
                    </Form.Select>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Update Interval</Form.Label>
                    <Form.Control
                        type="number"
                        name="updateInterval"
                        value={inventory.updateInterval}
                        onChange={handleChange}
                        className={'rounded-1'}
                    />
                    <small className="form-text text-muted">
                        Allows you to define the time in seconds for the refresh of the buttons in the inventory.
                        For the buttons to be updated you must have the update option enabled. More information <a
                        href={'https://zmenu.groupez.dev/configurations/buttons'} target={'_blank'}>here</a>.
                    </small>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Check
                        type="checkbox"
                        label="Clear Inventory"
                        name="clearInventory"
                        checked={inventory.clearInventory}
                        onChange={handleChange}
                        className={'rounded-1'}
                    />
                    <small className="form-text text-muted">
                        Allows you to delete the player's inventory on opening and restore it on closing. Allows for
                        example to use an image on your inventory without being hindered by the players' items.
                    </small>
                </Form.Group>

            </div>

        </div>
    )
}

export default InventoryConfiguration
