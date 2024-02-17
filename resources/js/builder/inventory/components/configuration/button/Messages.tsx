import {Form} from "react-bootstrap";
import AutoCompleteFormControl from "../../utils/AutoCompleteFormControl";

const Messages = ({currentSlot, handleChange}) => {

    return (
        <Form.Group>
            <hr/>
            <Form.Label>Message <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#messages'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>

            <AutoCompleteFormControl key={'messages'} name={'messages'} asControl={'textarea'} handleChange={handleChange} defaultValue={currentSlot.button?.messages ?? ''} />
        </Form.Group>
    )

}

export default Messages
