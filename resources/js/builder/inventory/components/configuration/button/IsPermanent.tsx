import {Form} from "react-bootstrap";

const IsPermanent = ({currentSlot, handleChange}) => {

    return (
        <Form.Group className="mb-2 d-flex">
            <Form.Check
                label="Is Permanent"
                type="checkbox"
                name="is_permanent"
                onChange={handleChange}
                checked={currentSlot.button?.is_permanent ?? false}
                className={'rounded-1'}
            />
            <a className={'ms-2'} href={'https://docs.groupez.dev/zmenu/configurations/buttons/button#is-permanent'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
        </Form.Group>
    )

}

export default IsPermanent
