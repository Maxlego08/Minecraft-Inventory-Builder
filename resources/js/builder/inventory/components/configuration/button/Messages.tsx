import {Form} from "react-bootstrap";

const Messages = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Message <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#messages'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
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
