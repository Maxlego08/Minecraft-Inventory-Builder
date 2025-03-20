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
                        <div key={index} className={'mt-2'}>
                            <div className={'d-flex justify-content-between'}>
                                <span>
                                    {action.name}
                                    { action.documentation_url && (<a className={'ms-2 text-decoration-none'}
                                                                      href={'https://docs.zmenu.dev/configurations/buttons/actions'}
                                                                      target={'_blank'}>(<i
                                        className="bi bi-question-lg"></i>)</a>)}
                                </span>
                                <span className={'cursor-pointer'} onClick={() => createNewAction(action)}>Add this action <i
                                    className="bi bi-arrow-right"></i></span>
                            </div>
                            <small className={'text-secondary'}>{action.description}</small>
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
