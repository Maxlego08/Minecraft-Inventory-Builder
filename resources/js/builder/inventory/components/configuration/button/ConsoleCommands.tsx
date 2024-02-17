import {Form} from "react-bootstrap";
import AutoCompleteFormControl from "../../utils/AutoCompleteFormControl";

const ConsoleCommands = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Console Commands <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#console-commands'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <AutoCompleteFormControl key={'console_commands'} name={'console_commands'} asControl={'textarea'} handleChange={handleChange} defaultValue={currentSlot.button?.console_commands ?? ''} />
        </Form.Group>
    )

}

export default ConsoleCommands
