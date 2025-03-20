import {Button, Modal} from 'react-bootstrap';

const AddActionModal = ({handleClose, show, actions, createNewAction}) => {

    return (
        <Modal show={show} onHide={handleClose} size={'lg'}>
            <Modal.Header closeButton>
                <Modal.Title>Add action</Modal.Title>
            </Modal.Header>
            <Modal.Body>
                {
                    actions.map((action, index) => (
                        <div key={index} className={'mt-2'} onClick={() => createNewAction(action)}>
                            {action.name}

                        </div>
                    ))
                }
            </Modal.Body>
            <Modal.Footer>
                <Button variant="secondary" size="sm" onClick={handleClose}>Close</Button>
            </Modal.Footer>
        </Modal>
    );
}

export default AddActionModal;
