import {Form} from "react-bootstrap";
import AutoCompleteFormControl from "../../utils/AutoCompleteFormControl";

const Commands = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Commands <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#commands'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <AutoCompleteFormControl key={'commands'} name={'commands'} asControl={'textarea'} handleChange={handleChange} defaultValue={currentSlot.button?.commands ?? ''} />
        </Form.Group>
    )

}

export default Commands
