import {Form} from "react-bootstrap";

const IsPermanent = ({currentSlot, handleChange}) => {

    return (
        <Form.Group className="mb-2 d-flex">
            <Form.Check
                label="Update"
                type="checkbox"
                name="update"
                onChange={handleChange}
                checked={currentSlot.button?.update ?? false}
                className={'rounded-1'}
            />
            <a className={'ms-2'} href={'https://docs.groupez.dev/zmenu/configurations/buttons/button#update'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
        </Form.Group>
    )

}

export default IsPermanent
