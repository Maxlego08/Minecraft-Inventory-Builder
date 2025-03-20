import { Form } from "react-bootstrap";

const BooleanType = ({ element, handleChange, defaultValue = false }) => {
    // Convertir "false" ou "true" en booléen si besoin
    // @ts-ignore
    const isChecked = defaultValue === true || defaultValue === "true";

    return (
        <Form.Group className="mb-2">
            <Form.Check
                type="checkbox"
                label={
                    <span className="text-capitalize d-flex">
                        {element.key}
                        {element.documentation_url && (
                            <a target="_blank" href={element.documentation_url} className="ms-1">
                                (?)
                            </a>
                        )}
                    </span>
                }
                name={element.key}
                checked={isChecked}
                onChange={(event) => handleChange(event, element)}
                className="rounded-1"
            />
            {element.description && (
                <small className="form-text text-muted">{element.description}</small>
            )}
        </Form.Group>
    );
};

export default BooleanType;
