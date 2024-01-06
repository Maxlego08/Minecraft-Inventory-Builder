import React from "react";
import api from '../../services/api'
import Folder from './Folder'

class FolderList extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            folder: [],
        };
    };

    componentDidMount() {
        this.handleFolderClick()
    };


    handleFolderClick = (serverId = null) => {
        console.log(serverId)
        api.fetchFolders(serverId).then(response => {
            console.log(response.data)
            if (response.data.result === 'success') {
                const folder = response.data.content;
                console.log(folder)
                this.setState({folder});
            } else {
                console.log('Error ! ')
            }
        }).catch(error => {
            console.log(error)
        });
    };

    render() {
        if (this.state.folder.length !== 0) {
            return (
                <div>
                    <div>
                        <span>{this.state.folder.name}</span>
                    </div>
                    <div>
                        <div style={{margin: '10px', padding: '10px'}}>
                            {this.state.folder.children?.map(folder => (
                                <Folder key={folder.id} folderId={folder.id} folderName={folder.name}
                                        onFolderClick={this.handleFolderClick}/>
                            ))}
                        </div>
                    </div>
                </div>
            );
        } else {
            return (
                <div>WAITING</div>
            )
        }
    };

};

export default FolderList
