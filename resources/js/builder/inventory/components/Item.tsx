const Item = ({item}) => {

    return (
        <div className={'item'}>
            <i className={"icon-minecraft " + item.css}></i>
        </div>
    )

}

export default Item
