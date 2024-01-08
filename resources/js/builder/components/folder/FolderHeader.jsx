const FolderHeader = ({handleParentFolder, parent}) => {

    const handleParentFolderClick = () => {
        handleParentFolder()
    }

    return (
        <div className={'folders-header'}>
            <div className={'action'}>
                <i className="bi bi-plus-lg"></i>
            </div>
            {parent ? (
                <div className={'action'} onClick={handleParentFolderClick}>
                    <i className="bi bi-arrow-90deg-left"></i>
                </div>
            ) : (
                <div className={'action action-disable'}>
                    <i className="bi bi-arrow-90deg-left"></i>
                </div>
            )}
        </div>
    )

}

export default FolderHeader
