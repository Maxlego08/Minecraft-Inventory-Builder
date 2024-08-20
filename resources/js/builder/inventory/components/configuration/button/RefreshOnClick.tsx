import {Form} from "react-bootstrap";

const IsPermanent = ({currentSlot, handleChange}) => {

    return (
        <Form.Group className="mb-2 d-flex">
            <Form.Check
                label="Refresh On Click"
                type="checkbox"
                name="refresh_on_click"
                onChange={handleChange}
                checked={currentSlot.button?.refresh_on_click ?? false}
                className={'rounded-1'}
            />
            <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#refreshonclick'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
        </Form.Group>
    )

}

export default IsPermanent
