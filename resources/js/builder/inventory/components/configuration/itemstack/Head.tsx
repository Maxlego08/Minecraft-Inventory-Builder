import {Dropdown, Form} from "react-bootstrap";
import api from '../../../../services/api'
import {useRef, useState} from "react";

const Head = ({handleChange, currentSlot}) => {

    const [search, setSearch] = useState("");
    const [head, setHead] = useState(null);
    const [heads, setHeads] = useState([]);
    const [showDropdown, setShowDropdown] = useState(false);
    const wrapperRef = useRef(null);

    const searchHead = (event) => {
        let value = event.target.value;
        setSearch(value);

        if (value.length <= 1) {
            setHead(null)
            setShowDropdown(false);
            return;
        }

        api.fetchHeads(value).then((response) => {
            setShowDropdown(true);
            setHeads(response.data);
        });
    };

    const handleBlur = (event) => {
        if (!wrapperRef.current.contains(event.relatedTarget)) {
            setShowDropdown(false);
        }
    };

    const handleClick = (head) => {
        setSearch(head.name)
        setHead(head)
        setShowDropdown(false);
    };

    const copyToClipboard = (text, type) => {
        window.toast("success", "Copied !", `You just copied ${type}`, 1000)
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        } else {
            let textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                textArea.remove();
                // @ts-ignore
                return Promise.resolve(true);
            } catch (err) {
                console.error(err);
                textArea.remove();
                // @ts-ignore
                return Promise.resolve(false);
            }
        }
    }

    return (
        <div ref={wrapperRef} onBlur={handleBlur} className="mb-3">
            <hr/>
            <div className={'mb-2 d-flex justify-content-between'}>
                <div>
                    {head && (
                        <img src={head.url} alt={head.name} width={35} height={35} className={'me-2'}/>
                    )}
                    Head configuration
                </div>
                {head && (
                    <div>
                        <small>
                            <a href={`https://minecraft-heads.com/custom-heads/head/${head.id}`} target={"_blank"}>More
                                informations here</a>
                        </small>
                    </div>
                )}
            </div>

            <Form.Group className="mb-3">
                <Form.Label>Search for a head</Form.Label>
                <Form.Control
                    type="text"
                    value={search}
                    name="search_head"
                    onChange={searchHead}
                    className={'rounded-1 mb-3'}
                    aria-autocomplete={"none"}
                />

                {showDropdown && (
                    <Dropdown.Menu show style={{
                        maxHeight: '300px',
                        overflowY: 'auto',
                        maxWidth: '460px',
                        overflowX: 'hidden'
                    }} variant={'dark'}>
                        {heads.length > 0 ? (
                            heads.map((option, index) => (
                                <Dropdown.Item key={index} onClick={() => handleClick(option)}>
                                    <img src={option.url} alt={'Head image'} width={25} height={25}
                                         className={'me-2'}/>{option.name}
                                </Dropdown.Item>
                            ))
                        ) : (
                            <Dropdown.Item disabled>No option found</Dropdown.Item>
                        )}
                    </Dropdown.Menu>
                )}

                {head && (
                    <div>
                        <Form.Label>Head value</Form.Label>
                        <div className="input-group mb-3">
                            <Form.Control
                                type="text"
                                value={head.data}
                                className={'rounded-1'}
                                disabled={true}
                            />
                            <button className="btn btn-outline-secondary" type="button" id="button-addon2"
                                    onClick={() => copyToClipboard(head.data, 'the value')}>Copy
                            </button>
                        </div>
                        <Form.Label>Head Database<a className={'ms-2'} href={'https://minecraft-heads.com/plugins/head-database'} target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a></Form.Label>
                        <div className="input-group">
                            <Form.Control
                                type="text"
                                value={`/hdb search id:${head.id}`}
                                className={'rounded-1'}
                                disabled={true}
                            />
                            <button className="btn btn-outline-secondary" type="button" id="button-addon2"
                                    onClick={() => copyToClipboard(`/hdb search id:${head.id}`, 'the command')}>Copy
                            </button>
                        </div>
                    </div>
                )}

            </Form.Group>
        </div>
    );
};

export default Head;
