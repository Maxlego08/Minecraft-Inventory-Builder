const FolderHeader = (parentFolder, handleParentFolderClick) => {

    const handleParentFolder = () => {
        handleParentFolderClick()
    }

    return (
        <div className={'folders-header'}>
            <div className={'action'}>
                <i className="bi bi-plus-lg"></i>
            </div>
            {parentFolder ? (
                <div className={'action'} onClick={handleParentFolder}>
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
