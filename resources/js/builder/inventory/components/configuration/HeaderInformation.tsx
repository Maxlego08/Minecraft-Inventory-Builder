import api from '../../../services/api'
import LockScrollButton from "../utils/LockScrollButton";
import {useState} from "react";
import InformationModal from "../modals/InformationModal";

const HeaderInformation = ({needToUpdate, saveData, inventoryId}) => {

    const [showModal, setShowModal] = useState(false);

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
                                <span className={"ms-1"}>Download</span>
                            </div>
                        ) : (
                            <a className={'enable action'} href={api.getDownloadUrl(inventoryId)} target={"_blank"}>
                                <i className="bi bi-cloud-download"></i>
                                <span className={"ms-1"}>Download</span>
                            </a>
                        )
                    }
                    <LockScrollButton/>
                    <span className={'action'} onClick={() => setShowModal(true)}>
                        <i className="bi bi-info-lg"></i> Informations
                    </span>
                    <InformationModal handleClose={() => setShowModal(false)} show={showModal}/>
                </div>
            </div>
        </div>
    )

}

export default HeaderInformation
