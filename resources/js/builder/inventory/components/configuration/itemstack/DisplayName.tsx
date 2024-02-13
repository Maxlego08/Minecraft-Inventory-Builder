import {Form} from "react-bootstrap";

const DisplayName = ({handleChange, displayName}) => {

    return (
        <Form.Group className="mb-3">
            <Form.Label>Display name</Form.Label>
            <Form.Control
                type="text"
                name="display_name"
                value={displayName ?? ''}
                onChange={handleChange}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default DisplayName
