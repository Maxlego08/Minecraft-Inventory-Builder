import * as React from "react";

const InventoryCard = ({inventory}) => {

    return (
        <div className={'inventory-card'}>
            <div className={'inventory-card-header'}>
                <span>{inventory.file_name}</span>
            </div>
            <div className={'inventory-card-actions'}>
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-pencil-square"/>
                </div>
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-copy"/>
                </div>
                <div className={'inventory-card-actions-element'}>
                    <i className="bi bi-trash text-danger"/>
                </div>
            </div>
        </div>
    )

}

export default InventoryCard
