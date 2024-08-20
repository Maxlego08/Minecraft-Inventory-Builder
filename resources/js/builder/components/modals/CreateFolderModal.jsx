import React, {useState} from 'react';
import {Button, Form, Modal} from 'react-bootstrap';

const CreateFolderModal = ({show, handleClose, onCreate}) => {
    const [folderName, setFolderName] = useState('');
    const [error, setError] = useState('');

    const validateName = (name) => /^[a-zA-Z0-9 ]{3,30}$/.test(name);

    const handleSubmit = (event) => {
        event.preventDefault();
        if (!validateName(folderName)) {
            setError('Le nom du dossier doit contenir entre 3 et 30 caractères et ne peut pas contenir de caractères spéciaux.');
            return;
        }
        setError('');
        onCreate(folderName);
        setFolderName('');
        handleClose(); // Fermer le modal après la création
    };

    return (
        <Modal show={show} onHide={handleClose}>
            <Modal.Header closeButton>
                <Modal.Title>Create a new folder</Modal.Title>
            </Modal.Header>
            <Form onSubmit={handleSubmit}>
                <Modal.Body>
                    {error && <p className="text-danger">{error}</p>}
                    <Form.Group className="mb-3">
                        <Form.Label>Folder name</Form.Label>
                        <Form.Control
                            type="text"
                            value={folderName}
                            onChange={(e) => setFolderName(e.target.value)}
                            isInvalid={!!error}
                            className={'rounded-0'}
                            minLength="3"
                            maxLength="30"
                        />
                        <Form.Control.Feedback type="invalid">
                            {error}
                        </Form.Control.Feedback>
                    </Form.Group>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" size="sm" onClick={handleClose}>
                        Cancel
                    </Button>
                    <Button variant='primary' type='submit' size='sm'>
                        Create
                    </Button>
                </Modal.Footer>
            </Form>
        </Modal>
    );
};

export default CreateFolderModal
