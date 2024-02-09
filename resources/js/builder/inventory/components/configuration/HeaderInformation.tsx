const HeaderInformation = ({needToUpdate, saveData}) => {

    return (
        <div className={"header-information"}>
            <div className={"card rounded-1"}>
                <div className={"card-body d-flex justify-content-between"}>
                    <div className={needToUpdate ? 'enable' : 'disable'} onClick={saveData}>
                        <i className="bi bi-floppy"></i>
                        <span className={"ms-1"}>Save</span>
                    </div>
                    <div className={needToUpdate ? 'enable' : 'disable'}>
                        <i className="bi bi-cloud-download"></i>
                        <span className={"ms-1"}>Download the inventory</span>
                    </div>
                </div>
            </div>
        </div>
    )

}

export default HeaderInformation
