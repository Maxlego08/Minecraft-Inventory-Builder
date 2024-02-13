import api from '../../../services/api'

const HeaderInformation = ({needToUpdate, saveData, inventoryId}) => {

    return (
        <div className={"header-information"}>
            <div className={"card rounded-1"}>
                <div className={"card-body d-flex justify-content-between"}>
                    <div className={needToUpdate ? 'enable' : 'disable'} onClick={saveData}>
                        <i className="bi bi-floppy"></i>
                        <span className={"ms-1"}>Save</span>
                    </div>
                    {
                        needToUpdate ? (
                            <div className={'disable'}>
                                <i className="bi bi-cloud-download"></i>
                                <span className={"ms-1"}>Download the inventory</span>
                            </div>
                        ) : (
                            <a className={'enable action'} href={api.getDownloadUrl(inventoryId)} target={"_blank"}>
                                <i className="bi bi-cloud-download"></i>
                                <span className={"ms-1"}>Download the inventory</span>
                            </a>
                        )
                    }
                </div>
            </div>
        </div>
    )

}

export default HeaderInformation
