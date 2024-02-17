import SearchableSelect from "../../utils/SearchableSelect";
import {Form} from "react-bootstrap";

const Sound = ({sounds, currentSlot, handleChange}) => {

    return (
        <div className={'mb-3'}>
            <hr/>
            <Form.Label>Sound <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons#sound'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
            <SearchableSelect key={'sound'} options={sounds} handleChange={handleChange} name={'sound'} defaultValue={currentSlot.button.sound}/>
            <div className={'row mt-2'}>
                <div className={'col-6'}>
                    <Form.Group>
                        <Form.Label>Pitch</Form.Label>
                        <Form.Control
                            name="pitch"
                            type="number"
                            min={0}
                            max={2}
                            step={0.01}
                            onChange={handleChange}
                            value={currentSlot.button.pitch}
                            className={'rounded-1'}
                        />
                    </Form.Group>
                </div>
                <div className={'col-6'}>
                    <Form.Group>
                        <Form.Label>Volume</Form.Label>
                        <Form.Control
                            name="volume"
                            type="number"
                            min={0}
                            max={9999999}
                            step={0.5}
                            onChange={handleChange}
                            value={currentSlot.button.volume}
                            className={'rounded-1'}
                        />
                    </Form.Group>
                </div>
            </div>
        </div>
    )

}

export default Sound
