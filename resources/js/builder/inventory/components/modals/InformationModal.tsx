import {Button, Modal} from 'react-bootstrap';

const InformationModal = ({handleClose, show}) => {

    return (
        <Modal show={show} onHide={handleClose} size={'lg'}>
            <Modal.Header closeButton>
                <Modal.Title>Information</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <p>
                    <div><i className="bi bi-floppy me-1"></i> Saves the inventory.</div>
                    <div><i className="bi bi-cloud-download me-1"></i> Allows you to download the YML configuration of the inventory.</div>
                    <div><i className="bi bi-lock me-1"></i> Allows to lock the page, you will no longer scroll.</div>
                    <div><i className="bi bi-info-lg me-1"></i> Displays the information of the inventory editor.</div>
                </p>
                <hr/>
                <p>
                    <div className={'h5 mb-1'}>Pickup an item</div>
                    <div><kbd>Left Click</kbd> to take an item with an amount of 1.</div>
                    <div><kbd>Shift</kbd> + <kbd>Left Click</kbd> to take an item with an amount 64.</div>
                </p>
                <hr/>
                <p>
                    <div className={'h5 mb-1'}>Place an item in the inventory.</div>
                    <div><kbd>Right Click</kbd> to place the item in inventory.</div>
                    <div><kbd>Left Click</kbd> to place a single item in the inventory.</div>
                    <div><kbd>Esc</kbd> to remove inventory from the hand</div>
                    <div><kbd>Left Click</kbd> on the page to remove inventory from the hand</div>
                </p>
                <hr/>
                <p>
                    <div className={'h5 mb-1'}>Interact with items in inventory</div>
                    <div><kbd>Left Click</kbd> to select a slot. You must select a slot before you can move the item.</div>
                    <div><kbd>Left Click</kbd> to take a whole item.</div>
                    <div><kbd>Right Click</kbd> to take half the item.</div>
                    <div><kbd>Shift</kbd> + <kbd>Left Click</kbd> to select multiple slots at the same time.</div>
                    <div><kbd>Shift</kbd> +<kbd>Arrow Up</kbd> to move your selected slot up.</div>
                    <div><kbd>Shift</kbd> +<kbd>Arrow Down</kbd> to move your selected slot down.</div>
                    <div><kbd>Shift</kbd> +<kbd>Arrow Right</kbd> to move your selected slot right.</div>
                    <div><kbd>Shift</kbd> +<kbd>Arrow Left</kbd> to move your selected slot left.</div>
                </p>
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={handleClose}>Close</Button>
            </Modal.Footer>
        </Modal>
    );

}

export default InformationModal
