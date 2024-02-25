import {Form} from "react-bootstrap";

const NumberType = ({element, handleChange, defaultValue = ''}) => {

    // ToDo add rules for the text

    return (
        <Form.Group className="mb-2">
            <Form.Label className={'text-capitalize d-flex'}>
                {element.key}
                {element.documentation_url && (<a target={'_blank'} href={element.documentation_url} className={'ms-1'}>(?)</a>)}
            </Form.Label>
            <Form.Control
                type={'number'}
                value={defaultValue}
                name={element.key}
                onChange={(event) => handleChange(event, element)}
                className={'rounded-1'}
            />
            {element.description && (<small className="form-text text-muted">{element.description}</small>)}
        </Form.Group>
    )

}

export default NumberType
