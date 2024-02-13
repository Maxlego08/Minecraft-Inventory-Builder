import {Form} from "react-bootstrap";

const Glow = ({currentSlot, handleChange}) => {

    return (
        <Form.Group className="mb-2 d-flex">
            <Form.Check
                label="Glow"
                type="checkbox"
                name="glow"
                onChange={handleChange}
                checked={currentSlot.button.glow}
                className={'rounded-1'}
            />
            <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/items#glow'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
        </Form.Group>
    )

}

export default Glow
