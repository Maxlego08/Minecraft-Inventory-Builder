import { useState, useEffect, useRef } from 'react';
import { Dropdown, Form } from 'react-bootstrap';

const SearchableSelect = ({ options, handleChange, name, defaultValue = '' }) => {
    const [searchTerm, setSearchTerm] = useState(defaultValue ?? '');
    const [showDropdown, setShowDropdown] = useState(false);
    const wrapperRef = useRef(null);

    useEffect(() => {
        setSearchTerm(defaultValue ?? '');
    }, [defaultValue]);

    const handleClick = (option) => {
        setSearchTerm(option);
        handleChange({
            target: { type: 'text', name: name, value: option, checked: false },
        });
        setShowDropdown(false);
    };

    const handleSearch = (event) => {
        setSearchTerm(event.target.value);
        setShowDropdown(event.target.value !== '');
        handleChange(event);
    };

    const filteredOptions = options.filter((option) =>
        option.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const handleBlur = (event) => {
        if (!wrapperRef.current.contains(event.relatedTarget)) {
            setShowDropdown(false);
        }
    };

    return (
        <div ref={wrapperRef} onBlur={handleBlur}>
            <Form.Control
                className={'rounded-1'}
                name={name}
                type="text"
                placeholder="Search..."
                value={searchTerm}
                onChange={handleSearch}
                onFocus={() => setShowDropdown(true)}
            />
            {showDropdown && (
                <Dropdown.Menu show style={{ maxHeight: '300px', overflowY: 'auto', maxWidth: '460px', overflowX: 'hidden' }} variant={'dark'}>
                    {filteredOptions.length > 0 ? (
                        filteredOptions.map((option, index) => (
                            <Dropdown.Item key={index} onClick={() => handleClick(option)}>
                                {option.toUpperCase()}
                            </Dropdown.Item>
                        ))
                    ) : (
                        <Dropdown.Item disabled>No option found</Dropdown.Item>
                    )}
                </Dropdown.Menu>
            )}
        </div>
    );
};

export default SearchableSelect;
