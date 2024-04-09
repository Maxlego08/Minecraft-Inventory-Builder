const InventoryVisibility = ({inventory}) => {

    const PRIVATE = 1
    const UNLISTED = 2
    const PUBLIC = 2

    switch (inventory.inventory_visibility_id) {
        case PRIVATE:
            return (
                <div>
                    <i className="bi bi-x-circle text-danger"></i> Private
                </div>
            )
        case UNLISTED:
            return (
                <div><i className="bi bi-link text-warning"></i> Unlisted</div>
            )
        case PUBLIC:
            return (
                <div><i className="bi bi-globe-americas text-success"></i> Public</div>
            )
        default:
            return (
                <div>Error</div>
            )
    }

}

export default InventoryVisibility
