import { useState } from 'react';

const LockScrollButton = () => {
    const [isLocked, setIsLocked] = useState(false);

    const toggleScrollLock = () => {
        setIsLocked(!isLocked);
        document.body.classList.toggle('lock-scroll', !isLocked);
    };

    return (
        <div onClick={toggleScrollLock} className={'action'}>
            {isLocked ? (<i className="bi bi-lock"></i>) : (<i className="bi bi-unlock"></i>)}
        </div>
    );
};

export default LockScrollButton;
