import {Form} from "react-bootstrap";

const Amount = ({handleChange, amount, maxStackSize = 64}) => {

    return (
        <Form.Group className="mb-3">

            <Form.Label>Amount: {amount}/{maxStackSize}</Form.Label>
            <Form.Range
                min={1}
                max={maxStackSize}
                name="amount"
                value={amount}
                onChange={handleChange}
                className={'rounded-1'}

            />
        </Form.Group>
    )

}

export default Amount
