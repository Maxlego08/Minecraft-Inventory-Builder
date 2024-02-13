import React, {useState} from 'react';
import {Button, Form, Modal} from 'react-bootstrap';
import Inventory from '../inventory/Inventory'

const CreateInventoryModal = ({show, handleClose, handleSave}) => {
    const [inventoryData, setInventoryData] = useState({
        name: '&8My Inventory',
        size: '9',
        updateInterval: '0',
        clearInventory: false,
        fileName: 'example'
    });
    const [error, setError] = useState('');

    const validateName = (name) => /^[a-zA-Z0-9-_]{3,100}$/.test(name);

    const handleChange = (e) => {
        const {name, value, type, checked} = e.target;
        setInventoryData(prevData => ({
            ...prevData,
            [name]: type === 'checkbox' ? checked : value
        }));

        if (!validateName(inventoryData.fileName)) {
            setError('Le nom du dossier doit contenir entre 3 et 100 caractères et ne peut pas contenir de caractères spéciaux.');
        } else setError('');
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        if (!validateName(inventoryData.fileName)) {
            setError('Le nom du dossier doit contenir entre 3 et 100 caractères et ne peut pas contenir de caractères spéciaux.');
            return;
        }
        setError('');

        handleSave(inventoryData);
    };

    return (
        <Modal show={show} onHide={handleClose} size={'lg'}>
            <Modal.Header closeButton>
                <Modal.Title>Add New Inventory</Modal.Title>
            </Modal.Header>
            <Form onSubmit={handleSubmit}>
                <Modal.Body>
                    <Form.Group className="mb-3">
                        <Form.Label>File name</Form.Label>
                        <Form.Control
                            type="text"
                            name="fileName"
                            value={inventoryData.fileName}
                            onChange={handleChange}
                            className={'rounded-1'}
                            placeholder={'Inventory'}
                            isInvalid={!!error}
                        />
                        <Form.Control.Feedback type="invalid">
                            {error}
                        </Form.Control.Feedback>
                    </Form.Group>
                    <Inventory inventoryName={inventoryData.name} inventorySize={inventoryData.size}/>
                    <Form.Group className="mb-3">
                        <Form.Label>Name</Form.Label>
                        <Form.Control
                            type="text"
                            name="name"
                            value={inventoryData.name}
                            onChange={handleChange}
                            className={'rounded-1'}
                            placeholder={'Inventory'}
                        />
                        <small className="form-text text-muted">
                            The name of the inventory that will be displayed. Please note that depending on your version
                            you have a character limit. You can use color and placeholders.
                        </small>
                    </Form.Group>
                    <Form.Group className="mb-3">
                        <Form.Label>Size</Form.Label>
                        <Form.Select name="size" value={inventoryData.size} onChange={handleChange}
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
                            value={inventoryData.updateInterval}
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
                            checked={inventoryData.clearInventory}
                            onChange={handleChange}
                            className={'rounded-1'}
                        />
                        <small className="form-text text-muted">
                            Allows you to delete the player's inventory on opening and restore it on closing. Allows for
                            example to use an image on your inventory without being hindered by the players' items.
                        </small>
                    </Form.Group>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" size="sm" onClick={handleClose}>
                        Cancel
                    </Button>
                    <Button variant="primary" type="submit" size={'sm'}>
                        Create
                    </Button>
                </Modal.Footer>
            </Form>
        </Modal>
    )
        ;
};

export default CreateInventoryModal;
