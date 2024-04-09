import {Button, Form, Modal} from "react-bootstrap";
import * as React from "react";
import {useState} from "react";
import api from "../../services/api"

const VisibilityModal = ({show, onClose, inventoryVisibility, inventory, updateInventory}) => {

    const [visibility, setVisibility] = useState(inventoryVisibility);

    const handleSubmit = (event) => {
        event.preventDefault();
        let visibilityId = visibility === 'private' ? 1 : visibility === 'public' ? 3 : 2;
        api.changeInventoryVisibility(inventory.id, visibilityId).then(response => {
            api.displayToast(response)
            updateInventory(inventory.id, {
                inventory_visibility_id: visibilityId
            })
        })
        onClose()
    };

    const handleChange = (value) => {
        setVisibility(value)
    }

    let downloadURL = `https://zmenu.dev/d/${inventory.id}`

    return (
        <Modal show={show} onHide={onClose}>
            <Modal.Header closeButton>
                <Modal.Title>Change Visibility</Modal.Title>
            </Modal.Header>
            <Form onSubmit={handleSubmit}>
                <Modal.Body>
                    <div className="form-check">
                        <input className="form-check-input" type="radio" name="visibility" id="private"
                               checked={visibility === 'private'} onChange={() => handleChange('private')}/>
                        <label className="form-check-label" htmlFor="private">Private</label>
                    </div>
                    <div className="form-check">
                        <input className="form-check-input" type="radio" name="visibility" id="unlisted"
                               checked={visibility === 'unlisted'} onChange={() => handleChange('unlisted')}/>
                        <label className="form-check-label" htmlFor="unlisted">Unlisted</label>
                    </div>
                    <div className="form-check">
                        <input className="form-check-input" type="radio" name="visibility" id="public"
                               checked={visibility === 'public'} onChange={() => handleChange('public')}/>
                        <label className="form-check-label" htmlFor="public">Public</label>
                    </div>
                    {
                        (visibility === 'unlisted' || visibility === 'public') && (
                            <div className={'mt-3 d-flex flex-column'}>
                                <h5 className={'text-center'}>Download Link</h5>
                                <input type={"text"} value={downloadURL} />
                            </div>
                        )
                    }
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" size="sm" onClick={onClose}>
                        Cancel
                    </Button>
                    <Button variant='primary' type='submit' size='sm'>
                        Save
                    </Button>
                </Modal.Footer>
            </Form>
        </Modal>
    )
}

export default VisibilityModal
