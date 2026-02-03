import {Form} from "react-bootstrap";

const CloseInventory = ({currentSlot, handleChange}) => {

    return (
        <Form.Group className="mb-2 d-flex">
            <Form.Check
                label="Close Inventory"
                type="checkbox"
                name="close_inventory"
                onChange={handleChange}
                checked={currentSlot.button?.close_inventory ?? false}
                className={'rounded-1'}
            />
            <a className={'ms-2'} href={'https://docs.groupez.dev/zmenu/configurations/buttons/button#close-inventory'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
        </Form.Group>
    )

}

export default CloseInventory
