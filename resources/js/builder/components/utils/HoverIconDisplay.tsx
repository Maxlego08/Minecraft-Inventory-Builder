import { useState } from 'react';

const HoverIconDisplay = ({ children, onClick }) => {
    const [isHovered, setIsHovered] = useState(false);

    return (
        <div onMouseEnter={() => setIsHovered(true)} onMouseLeave={() => setIsHovered(false)} className={'actions-element'} onClick={onClick}>
            {children}
            {isHovered && <i className="bi bi-caret-down-fill ms-2"></i>}
        </div>
    );
};

export default HoverIconDisplay
