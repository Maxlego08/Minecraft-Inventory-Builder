import {Form} from "react-bootstrap";

const TextType = ({element, handleChange}) => {

    return (
        <Form.Group className="mb-2">
            <Form.Label>{element.key}</Form.Label>
            <Form.Control
                type="text"
                name={element.key}
                onChange={handleChange}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default TextType
