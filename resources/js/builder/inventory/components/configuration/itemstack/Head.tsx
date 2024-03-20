import {Dropdown, Form} from "react-bootstrap";
import api from '../../../../services/api'
import {useRef, useState} from "react";

const Head = ({handleChange, currentSlot, updateHead}) => {

    const [search, setSearch] = useState(currentSlot?.button?.head?.name ?? "");
    const [head, setHead] = useState(currentSlot?.button?.head ?? null);
    const [heads, setHeads] = useState([]);
    const [showDropdown, setShowDropdown] = useState(false);
    const wrapperRef = useRef(null);

    const searchHead = (event) => {
        let value = event.target.value;
        setSearch(value);

        if (value.length <= 1) {
            setHead(null)
            setShowDropdown(false);
            updateHead(null)
            return;
        }

        api.fetchHeads(value).then((response) => {
            setShowDropdown(true);
            setHeads(response.data);
        });
    };

    const handleFocus = () => {
        if (search.length > 1) {
            setShowDropdown(true);
        }
    }

    const handleBlur = (event) => {
        if (!wrapperRef.current.contains(event.relatedTarget)) {
            setShowDropdown(false);
        }
    };

    const handleClick = (head) => {
        setSearch(head.name)
        setHead(head)
        setShowDropdown(false);
        updateHead(head)
    };

    const copyToClipboard = (text, type) => {
        // @ts-ignore
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

    return (<div ref={wrapperRef} onBlur={handleBlur} className="mb-3">
            <div className={'mb-2 d-flex justify-content-between'}>
                <div>
                    {head && (<img src={api.getHeadUrl(head.image_name)} alt={head.name} width={35} height={35}
                                   className={'me-2'}/>)}
                    Head configuration
                </div>
                {head && (<div>
                        <small>
                            <a href={`https://minecraft-heads.com/custom-heads/head/${head.url_id}`} target={"_blank"}>More
                                informations here</a>
                        </small>
                    </div>)}
            </div>

            <Form.Group className="mb-3">
                <Form.Label>Search for a head</Form.Label>
                <Form.Control
                    type="text"
                    value={search}
                    name="search_head"
                    onChange={searchHead}
                    onFocus={handleFocus}
                    className={'rounded-1 mb-3'}
                    autoComplete="off"
                />

                {showDropdown && (<Dropdown.Menu show style={{
                        maxHeight: '300px', overflowY: 'auto', maxWidth: '460px', overflowX: 'hidden'
                    }} variant={'dark'}>
                        {heads.length > 0 ? (heads.map((option, index) => (
                                <Dropdown.Item key={index} onClick={() => handleClick(option)}>
                                    <img src={api.getHeadUrl(option.image_name)} alt={'Head image'} width={25}
                                         height={25}
                                         className={'me-2'}/>{option.name}
                                </Dropdown.Item>))) : (<Dropdown.Item disabled>No option found</Dropdown.Item>)}
                    </Dropdown.Menu>)}

                {head && (<div>
                        <Form.Label>Head value</Form.Label>
                        <div className="input-group mb-3">
                            <Form.Control
                                type="text"
                                value={head.head_url}
                                className={'rounded-1'}
                                disabled={true}
                            />
                            <button className="btn btn-outline-secondary" type="button" id="button-addon2"
                                    onClick={() => copyToClipboard(head.head_url, 'the value')}>Copy
                            </button>
                        </div>
                        <Form.Label>zHead Database<a className={'ms-2'}
                                                    href={'https://www.spigotmc.org/resources/zhead-database.115717/'}
                                                    target={'_blank'}>(<i
                            className="bi bi-question-lg"></i>)</a></Form.Label>
                        <div className="input-group">
                            <Form.Control
                                type="text"
                                value={`/zhd search id:${head.url_id}`}
                                className={'rounded-1'}
                                disabled={true}
                            />
                            <button className="btn btn-outline-secondary" type="button" id="button-addon2"
                                    onClick={() => copyToClipboard(`/zhd search id:${head.url_id}`, 'the command')}>Copy
                            </button>
                        </div>
                    </div>)}

            </Form.Group>
            <hr/>
        </div>);
};

export default Head;
