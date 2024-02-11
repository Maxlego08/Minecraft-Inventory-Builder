import {useEffect, useState} from 'react';
import minecraftLang from '../../../services/minecraftLang'
import minecraftColor from "../../../services/minecraftColor";
import DOMPurify from 'dompurify';

const Tooltip = ({item, itemRef, button}) => {
    const [tooltipPosition, setTooltipPosition] = useState({top: 0, left: 0});
    const [showTooltip, setShowTooltip] = useState(false);

    const moveTooltip = (event) => {
        const top = event.clientY - 20;
        const left = event.clientX + 10;
        setTooltipPosition({top, left});
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
    }, [itemRef]);

    let itemName = minecraftLang.translate(item.name)
    const processedName = button?.display_name ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(button.display_name)) : itemName;
    const processedLore = button?.lore ? DOMPurify.sanitize(minecraftColor.processMinecraftColorCodes(button.lore)) : '';

    return showTooltip ? (
        <div
            className={'minecraft-tooltip'}
            style={{top: tooltipPosition.top + 'px', left: tooltipPosition.left + 'px'}}
        >
            <span className={button?.display_name ? '' : 'minecraft-tooltip-title'}
                  dangerouslySetInnerHTML={{__html: processedName}}></span>
            {
                button?.lore && (<pre className={"tooltip-description"} dangerouslySetInnerHTML={{__html: processedLore}}></pre>)
            }
        </div>
    ) : null;
};

export default Tooltip
