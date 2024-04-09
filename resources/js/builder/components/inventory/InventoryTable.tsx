import {useEffect, useState} from "react";
import {Form} from "react-bootstrap";
import date from '../../services/dateFormat'
import color from '../../services/minecraftColor'
import DOMPurify from 'dompurify';
import InventoryVisibility from "./InventoryVisibility";

const InventoryTable = ({inventories, folder}) => {

    const [data, setData] = useState(inventories);
    const [sortConfig, setSortConfig] = useState({key: 'created_at', direction: 'ascending'});


    useEffect(() => {
        setData(inventories);
    }, [inventories]);

    const sortData = (key) => {
        let direction = 'ascending';
        if (sortConfig.key === key && sortConfig.direction === 'ascending') {
            direction = 'descending';
        }
        const sortedData = [...data].sort((a, b) => {
            if (a[key] < b[key]) {
                return direction === 'ascending' ? -1 : 1;
            }
            if (a[key] > b[key]) {
                return direction === 'ascending' ? 1 : -1;
            }
            return 0;
        });
        setData(sortedData);
        setSortConfig({key, direction});
    };

    const getClassName = (key) => `sort${sortConfig.key === key ? ' sort-current' : ''}`;

    const getArrow = (key) => sortConfig.key !== key ? '' : sortConfig.direction === 'ascending' ? <i className="bi bi-arrow-down"></i> : <i className="bi bi-arrow-up"></i>

    return (
        <div className={'inventory-table'}>

            <div className={'inventory-table-search'}>
                <div className={'search-icon'}>
                    <i className="bi bi-filter"></i>
                </div>
                <div className={'search-bar'}>
                    <Form.Control
                        type="text"
                        value={''}
                        placeholder={'Filter'}
                        onChange={(e) => {

                        }}
                        className={'rounded-0'}
                    />
                </div>
            </div>
            <hr/>
            <div className={'inventory-table-content'}>
                <table className="table table-responsive table-striped table-hover">
                    <thead>
                    <tr>
                        <th className={'select'}></th>
                        <th className={getClassName('file_name')} onClick={() => sortData('file_name')}>File Name {getArrow('file_name')}</th>
                        <th className={getClassName('name')} onClick={() => sortData('name')}>Name {getArrow('name')}</th>
                        <th className={getClassName('inventory_visibility_id')} onClick={() => sortData('inventory_visibility_id')}>Visibility {getArrow('inventory_visibility_id')}</th>
                        <th className={getClassName('created_at')} onClick={() => sortData('created_at')}>Created at {getArrow('created_at')}</th>
                        <th className={getClassName('updated_at')} onClick={() => sortData('updated_at')}>Updated at {getArrow('updated_at')}</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {data.map((inventory) => (
                        <tr key={inventory.id}>
                            <td>
                                <input className="form-check-input" type="checkbox" value="" id="select" />
                            </td>
                            <td>{inventory.file_name}</td>
                            <td dangerouslySetInnerHTML={{__html: inventory.name ? DOMPurify.sanitize(color.processMinecraftColorCodes(inventory.name)) : 'Inventory'}}></td>
                            <td>
                                <InventoryVisibility key={`${inventory.id}-visibility`} inventory={inventory}/>
                            </td>
                            <td>{date.formatDate(inventory.created_at)}</td>
                            <td>{date.formatDate(inventory.updated_at)}</td>
                            <td className={'inventory-table-content-actions'}>
                                <a className={'inventory-card-actions-element'} href={`/builder/inventory/${inventory.id}#builder`}>
                                    <i className="bi bi-pencil-square"/>
                                </a>
                                <div className={'inventory-card-actions-element'}>
                                    <i className="bi bi-copy"/>
                                </div>
                                <div className={'inventory-card-actions-element'}>
                                    <i className="bi bi-trash text-danger"/>
                                </div>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
        </div>
    )

}
export default InventoryTable
