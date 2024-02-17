import {Form} from "react-bootstrap";

const ConsoleCommands = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Console Commands <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#console-commands'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <Form.Control
                name="console_commands"
                as={'textarea'}
                rows={8}
                onChange={handleChange}
                value={currentSlot.button?.console_commands ?? ''}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default ConsoleCommands
