import { useState, useEffect } from 'react';
import minecraftLang from '../../../services/minecraftLang'

const Tooltip = ({ item, itemRef }) => {
    const [tooltipPosition, setTooltipPosition] = useState({ top: 0, left: 0 });
    const [showTooltip, setShowTooltip] = useState(false);

    const moveTooltip = (event) => {
        const top = event.clientY - 20;
        const left = event.clientX + 10;
        setTooltipPosition({ top, left });
    };

    useEffect(() => {
        const handleMouseEnter = (event) => {
            setShowTooltip(true);
            moveTooltip(event);
        }
        const handleMouseMove = (event) => moveTooltip(event);
        const handleMouseLeave = () => setShowTooltip(false);

        const node = itemRef.current;
        if (node) {
            node.addEventListener('mouseenter', handleMouseEnter);
            node.addEventListener('mousemove', handleMouseMove);
            node.addEventListener('mouseleave', handleMouseLeave);
        }

        return () => {
            if (node) {
                node.removeEventListener('mouseenter', handleMouseEnter);
                node.removeEventListener('mousemove', handleMouseMove);
                node.removeEventListener('mouseleave', handleMouseLeave);
            }
        };
    }, [itemRef]); // Dépendance à itemRef pour s'assurer que les événements sont correctement attachés/détachés

    return showTooltip ? (
        <div
            className={'minecraft-tooltip'}
            style={{ top: tooltipPosition.top + 'px', left: tooltipPosition.left + 'px' }}
        >
            <span className={'minecraft-tooltip-title'}>{minecraftLang.translate(item.name)}</span>
        </div>
    ) : null;
};

export default Tooltip
