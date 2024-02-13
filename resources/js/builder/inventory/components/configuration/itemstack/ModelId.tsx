import {Form} from "react-bootstrap";

const ModelId = ({handleChange, currentSlot}) => {

    return (
        <Form.Group className="mb-3">
            <Form.Label>Custom Model Id <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/items#modelid'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <Form.Control
                type="number"
                min={0}
                max={9999999}
                name="model_id"
                value={currentSlot.model_id}
                onChange={handleChange}
                className={'rounded-1'}
            />
        </Form.Group>
    )

}

export default ModelId
