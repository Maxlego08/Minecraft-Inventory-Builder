import {useState} from 'react';
import {Dropdown, Form} from 'react-bootstrap';

const SearchableSelect = ({options}) => {
    const [searchTerm, setSearchTerm] = useState('');
    const [showDropdown, setShowDropdown] = useState(false);

    const handleSearch = (event) => {
        setSearchTerm(event.target.value.toLowerCase());
        setShowDropdown(event.target.value !== '');
    };

    const filteredOptions = options.filter(option =>
        option.name.toLowerCase().includes(searchTerm)
    );


    return (
        <div>
            <Form.Control
                className={'rounded-1'}
                name="button_type"
                type="text"
                placeholder="Rechercher..."
                value={searchTerm}
                onChange={handleSearch}
                onFocus={() => setShowDropdown(true)}
                onBlur={() => setTimeout(() => setShowDropdown(false), 100)}
            />
            {showDropdown && (
                <Dropdown.Menu show style={{ maxHeight: '300px', overflowY: 'auto' }}>
                    {filteredOptions.length > 0 ? (
                        filteredOptions.map((option, index) => (
                            <Dropdown.Item key={index} onClick={() => setSearchTerm(option.name)}>
                                {option.name.toUpperCase()}
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

export default SearchableSelect
