import { Modal, Button } from 'react-bootstrap';

const InformationModal = ({handleClose, show}) => {

    return (
        <Modal show={show} onHide={handleClose} size={'lg'}>
            <Modal.Header closeButton>
                <Modal.Title>Information</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                <p>Pour copier, utilisez <kbd>Ctrl</kbd> + <kbd>C</kbd>.</p>
                <p>Pour coller, utilisez <kbd>Ctrl</kbd> + <kbd>V</kbd>.</p>
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={handleClose}>Close</Button>
            </Modal.Footer>
        </Modal>
    );

}

export default InformationModal
