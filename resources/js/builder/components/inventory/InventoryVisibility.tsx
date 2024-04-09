import { useState } from "react";
import Tooltip from "../utils/ToolTip";
import HoverIconDisplay from "../utils/HoverIconDisplay";
import VisibilityModal from "../modals/VisibilityModal";

const InventoryVisibility = ({ inventory, updateInventory }) => {
    const [modalShow, setModalShow] = useState(false);

    const visibilityTypes = {
        1: { label: "Private", icon: "bi-x-circle text-danger", description: "Private\nOnly you can download this inventory.\nThis video will not appear on your profile page." },
        2: { label: "Unlisted", icon: "bi-link text-warning", description: "Unlisted\nAny user who has the link to this inventory can download it.\nThis inventory will not appear on your page, nor will it appear in search results." },
        3: { label: "Public", icon: "bi-globe-americas text-success", description: "Public\nEveryone can view and download this inventory" },
    };

    const handleModalToggle = () => setModalShow(!modalShow);

    const visibility = visibilityTypes[inventory.inventory_visibility_id];

    if (!visibility) return <div>Error</div>;

    return (
        <>
            <HoverIconDisplay onClick={handleModalToggle}>
                <Tooltip text={visibility.description}>
                    <i className={`bi ${visibility.icon}`}></i>
                </Tooltip>
                <span className="ms-2">{visibility.label}</span>
            </HoverIconDisplay>
            <VisibilityModal show={modalShow} onClose={handleModalToggle} inventoryVisibility={visibility.label.toLowerCase()}
                             inventory={inventory} updateInventory={updateInventory}/>
        </>
    );
}

export default InventoryVisibility;
