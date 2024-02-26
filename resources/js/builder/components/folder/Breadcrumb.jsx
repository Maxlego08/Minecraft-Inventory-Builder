import React from "react";

const Breadcrumb = ({ parent, folder, onFolderClick, homeFolderId }) => {

    return (
        <div className={'builder-breadcrumb'}>
            <nav aria-label="breadcrumb">
                <ol className="breadcrumb">
                    <li className="breadcrumb-item can-click"><span onClick={() => onFolderClick(homeFolderId)}><i className="bi bi-house"></i> Home</span>
                    </li>
                    {parent && parent.size !== 0 && parent.map((info, index) => (
                        <li key={index}
                            className={`breadcrumb-item ${info.name === folder.name ? 'active' : 'can-click'}`}
                            aria-current={info.name === folder.name ? "page" : undefined}>
                            {info.name === folder.name ? (
                                <span>{info.name}</span>
                            ) : (
                                <span onClick={() => onFolderClick(info.id)}>{info.name}</span>
                            )}
                        </li>
                    ))}
                </ol>
            </nav>
        </div>
    )

}

export default Breadcrumb
