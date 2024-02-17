import { useEffect, useRef, useState } from 'react';
import { Form } from 'react-bootstrap';

const AutoCompleteFormControl = ({ name, asControl = 'text', handleChange, defaultValue = '' }) => {
    const [inputValue, setInputValue] = useState(defaultValue);
    const [showSuggestions, setShowSuggestions] = useState(false);
    const wrapperRef = useRef(null);

    const suggestions = ['%player%', '%page%', '%maxPage%'];

    useEffect(() => {
        setInputValue(defaultValue);
    }, [defaultValue]);

    const getSuggestionsPosition = () => {
        if (wrapperRef.current) {
            const rect = wrapperRef.current.getBoundingClientRect();
            return {
                left: rect.left + window.scrollX + 10,
                top: rect.bottom + window.scrollY - 170,
            };
        }
        return { left: 0, top: 0 };
    };

    const getCurrentWord = (text) => {
        const words = text.split(/\s+/);
        return words[words.length - 1];
    };


    return (
        <Form.Group ref={wrapperRef}>
            <Form.Control
                // @ts-ignore
                as={asControl}
                name={name}
                rows={8}
                className={'rounded-1'}
                value={inputValue}
                onChange={(event) => {
                    const newValue = event.target.value;
                    setInputValue(newValue);
                    handleChange(event);
                    // @ts-ignore
                    setShowSuggestions(newValue.includes('%') && getCurrentWord(newValue).startsWith('%'));
                }}
            />
            {showSuggestions && (
                <ul style={{
                    listStyleType: 'none',
                    padding: '5px',
                    border: '1px solid #ddd',
                    position: 'absolute',
                    ...getSuggestionsPosition(),
                    zIndex: 1000,
                }}>
                    {// @ts-ignore
                        suggestions.filter(suggestion => suggestion.includes(getCurrentWord(inputValue))).map(filteredSuggestion => (
                        <li
                            key={filteredSuggestion}
                            style={{ cursor: 'pointer' }}
                            onClick={() => {
                                const lastWordRegex = new RegExp(getCurrentWord(inputValue) + '$');
                                const newValue = inputValue.replace(lastWordRegex, filteredSuggestion);
                                setInputValue(newValue);
                                setShowSuggestions(false);
                                handleChange({ target: { name: name, value: newValue } });
                            }}
                        >
                            {filteredSuggestion}
                        </li>
                    ))}
                </ul>
            )}
        </Form.Group>
    );
};

export default AutoCompleteFormControl;
