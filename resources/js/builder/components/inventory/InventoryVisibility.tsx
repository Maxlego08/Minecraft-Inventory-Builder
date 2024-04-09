import Tooltip from "../utils/ToolTip";
import HoverIconDisplay from "../utils/HoverIconDisplay";
import {useState} from "react";
import VisibilityModal from "../modals/VisibilityModal";

const InventoryVisibility = ({inventory, updateInventory}) => {

    const [modalShow, setModalShow] = useState(false);

    const handleModalClose = () => setModalShow(false);
    const handleModalShow = () => setModalShow(true);

    const PRIVATE = 1
    const UNLISTED = 2
    const PUBLIC = 3

    switch (inventory.inventory_visibility_id) {
        case PRIVATE:
            return (
                <>
                    <HoverIconDisplay onClick={handleModalShow}>
                        <Tooltip text="Private
                        Only you can download this inventory.
                        This video will not appear on your profile page.">
                            <i className="bi bi-x-circle text-danger"></i>
                        </Tooltip>
                        <span className={'ms-2'}>Private</span>
                    </HoverIconDisplay>
                    <VisibilityModal show={modalShow} onClose={handleModalClose} inventoryVisibility={'private'}
                                     inventory={inventory} updateInventory={updateInventory}/>
                </>
            )
        case UNLISTED:
            return (
                <>
                    <HoverIconDisplay onClick={handleModalShow}>
                        <Tooltip text="Unlisted
                    Any user who has the link to this inventory can download it.
                    This inventory will not appear on your page, nor will it appear in search results.">
                            <i className="bi bi-link text-warning"></i>
                        </Tooltip>
                        <span className={'ms-2'}>Unlisted</span>
                    </HoverIconDisplay>
                    <VisibilityModal show={modalShow} onClose={handleModalClose} inventoryVisibility={'unlisted'}
                                     inventory={inventory} updateInventory={updateInventory}/>
                </>
            )
        case PUBLIC:
            return (
                <>
                    <HoverIconDisplay onClick={handleModalShow}>
                        <Tooltip text="Public
                                Everyone can view and download this inventory">
                            <i className="bi bi-globe-americas text-success"></i>
                        </Tooltip>
                        <span className={'ms-2'}> Public</span>
                    </HoverIconDisplay>
                    <VisibilityModal show={modalShow} onClose={handleModalClose} inventoryVisibility={'public'}
                                     inventory={inventory} updateInventory={updateInventory}/>
                </>
            )
        default:
            return (
                <div>Error</div>
            )
    }

}

export default InventoryVisibility
