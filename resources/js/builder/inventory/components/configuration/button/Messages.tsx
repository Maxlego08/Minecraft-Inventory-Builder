import {Form} from "react-bootstrap";

const Messages = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <Form.Label>Message</Form.Label>
            <Form.Control
                name="messages"
                as={'textarea'}
                rows={10}
                onChange={handleChange}
                value={currentSlot.button.messages}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default Messages
