import {useEffect, useState} from "react";
import TextareaType from "./types/TextaeraType";
import BooleanType from "./types/BooleanType";
import NumberType from "./types/NumberType";
import TextType from "./types/TextType";
import FloatType from "./types/FloatType";
import AddActionModal from "../../modals/AddActionModal";

const Actions = ({currentSlot, actions, updateActions}) => {

    const [currentActions, setCurrentActions] = useState([]);
    const [showModal, setShowModal] = useState(false);
    useEffect(() => setCurrentActions(currentSlot.button.actions))

    const handleChange = () => {

    }

    const findActionTypes = (actionId) => {
        return actions.find(action => action.id === actionId);
    }

    const createNewAction = (action) => {
        setShowModal(false)

        let jsonContentArray = {}
        action.contents.forEach((content) => {
            jsonContentArray[content.key] = content.value ?? '';
        });
        let jsonContent = JSON.stringify(jsonContentArray)
        let newAction = {
            inventory_button_id: currentSlot.button.id,
            inventory_action_type_id: action.id,
            data: jsonContent
        }
        console.log(newAction)

        setCurrentActions([...currentActions, newAction])
        updateActions([...currentActions, newAction])
    }

    const deleteAction = (action) => {
        updateActions(currentActions.filter(a => a != action))
    }

    return (<div>
        <hr/>
        <div className={'configurations-button-header-second mb-2'}>
            <div>
                Actions <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons/actions'}
                           target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
            </div>
            <div className={'btn btn-sm btn-secondary action'} onClick={() => setShowModal(true)}>
                <i className="bi bi-plus-lg"></i> Add an action
            </div>
        </div>

        <div className="mb-2">
            <div className="builder-accordion">
                {currentActions.map((action, index) => {
                    const currentAction = findActionTypes(action.inventory_action_type_id)

                    if (currentActions == null) {
                        return (<div>Impossible to find the action {action.inventory_action_type_id}</div>)
                    }

                    const handleChangeData = (event, element) => {

                        let key = element.key;
                        let newValue = event.target.type === 'checkbox' ? event.target.checked : event.target.value;
                        if (element.type === 'number') {
                            const numericValue = parseInt(newValue);
                            newValue = isNaN(numericValue) ? 0 : numericValue;
                        }

                        console.log(key)
                        console.log(newValue)

                        const oldAction = currentActions[index];
                        const oldData = oldAction.data ? JSON.parse(oldAction.data) : {};
                        const newData = {...oldData, [key]: newValue};
                        const newActions = currentActions.map((a, i) => i === index ? {
                            ...a,
                            data: JSON.stringify(newData)
                        } : a);

                        updateActions(newActions)
                    }

                    return (
                        <div key={index}>
                            <label htmlFor={`item-${index}`}
                                   className="builder-accordion-header text-capitalize d-flex justify-content-between">
                                {currentAction.name}
                                <i className="bi bi-trash cursor-pointer text-danger"
                                   onClick={() => deleteAction(action)}/>
                            </label>
                            <div className="builder-accordion-content">
                                <small className="form-text text-muted">{currentAction.description}</small>
                                {currentAction?.contents?.map((actionType, indexType) => {

                                    if (actionType.data_type === 'textarea') {
                                        return (<TextareaType key={`${indexType}-textarea`} element={actionType}
                                                              handleChange={handleChangeData}
                                                              defaultValue={action.data ? JSON.parse(action.data)[actionType.key] : ''}/>)
                                    } else if (actionType.data_type === 'bool') {
                                        return (<BooleanType
                                            key={`${indexType}-bool`} element={actionType}
                                            handleChange={handleChangeData}
                                            defaultValue={action.data ? JSON.parse(action.data)[actionType.key] : false
                                            }/>)
                                    } else if (actionType.data_type === 'integer') {
                                        return (<NumberType
                                            key={`${indexType}-integer`} element={actionType}
                                            handleChange={handleChangeData}
                                            defaultValue={action.data ? JSON.parse(action.data)[actionType.key] : false
                                            }/>)
                                    } else if (actionType.data_type === 'string') {
                                        return (<TextType
                                            key={`${indexType}-string`} element={actionType}
                                            handleChange={handleChangeData}
                                            defaultValue={action.data ? JSON.parse(action.data)[actionType.key] : false
                                            }/>)
                                    } else if (actionType.data_type === 'float') {
                                        return (<FloatType
                                            key={`${indexType}-string`} element={actionType}
                                            handleChange={handleChangeData}
                                            defaultValue={action.data ? JSON.parse(action.data)[actionType.key] : false
                                            }/>)
                                    } else {
                                        return (
                                            <div key={`${indexType}-empty`}>Plz, that is not normal, contact Maxlego08
                                                on discord!</div>)
                                    }
                                })}
                            </div>
                            <hr/>
                        </div>
                    )
                })}
            </div>
        </div>
        <AddActionModal handleClose={() => setShowModal(false)} show={showModal} actions={actions}
                        createNewAction={createNewAction}/>
    </div>)

}

export default Actions
