import { useState } from 'react';

const Tooltip = ({ children, text }) => {
    const [isVisible, setIsVisible] = useState(false);

    return (
        <div className="tooltip-inventory-container">
            <div
                onMouseOver={() => setIsVisible(true)}
                onMouseOut={() => setIsVisible(false)}
            >
                {children}
            </div>
            {isVisible && (
                <div className="tooltip-inventory-box">
                    {text.split('\n').map((line, index) => (
                        <div key={index}>{line}</div>
                    ))}
                </div>
            )}
        </div>
    );
};

export default Tooltip;
