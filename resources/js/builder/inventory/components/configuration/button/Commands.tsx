import {Form} from "react-bootstrap";

const Commands = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Commands <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#commands'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <Form.Control
                name="commands"
                as={'textarea'}
                rows={8}
                onChange={handleChange}
                value={currentSlot.button?.commands ?? ''}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default Commands
