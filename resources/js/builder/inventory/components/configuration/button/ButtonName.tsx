import {Form} from "react-bootstrap";

const ButtonName = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <Form.Label>Name</Form.Label>
            <Form.Control
                name="name"
                type="text"
                onChange={handleChange}
                value={currentSlot.button.name}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default ButtonName
