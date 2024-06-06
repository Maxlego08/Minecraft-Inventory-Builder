import React, {useRef} from 'react';
import { Modal, Button } from 'react-bootstrap';

const DeleteConfirmationModal = ({ show, handleClose, handleConfirm, itemToDelete }) => {

    const wrapperRef = useRef(itemToDelete);

    return (
        <Modal show={show} onHide={handleClose} ref={wrapperRef}>
            <Modal.Header closeButton>
                <Modal.Title>Confirm Copy</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                Are you sure you want to copy {itemToDelete} ?
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={handleClose}>
                    Cancel
                </Button>
                <Button variant="danger" size="sm" onClick={handleConfirm}>
                    <i className="bi bi-trash"/> Copy
                </Button>
            </Modal.Footer>
        </Modal>
    );
};

export default DeleteConfirmationModal;
