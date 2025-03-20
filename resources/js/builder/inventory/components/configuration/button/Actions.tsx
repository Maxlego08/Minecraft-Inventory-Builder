import {useEffect, useState} from "react";
import TextareaType from "./types/TextaeraType";

const Actions = ({currentSlot, actions, updateActions}) => {

    const [currentActions, setCurrentActions] = useState([]);
    useEffect(() => setCurrentActions(currentSlot.button.actions))

    const handleChange = () => {

    }

    const findActionTypes = (actionId) => {
        return actions.find(action => action.id === actionId);
    }

    return (<div>
        <hr/>
        <div className={'configurations-button-header-second mb-2'}>
            <div>
                Actions <a className={'ms-2'} href={'https://docs.zmenu.dev/configurations/buttons/actions'}
                           target={'_blank'}>(<i className="bi bi-question-lg"></i>)</a>
            </div>
            <div className={'btn btn-sm btn-secondary'}>
                <i className="bi bi-plus-lg"></i> Add an action
            </div>
        </div>

        <div className="mb-2">
            <div className="builder-accordion">
                {currentActions.map((action, index) => {
                    const currentAction = findActionTypes(action.inventory_action_type_id)

                    if (currentActions == null) {
                        return (<div>ERROR</div>)
                    }

                    const handleChangeData = (event, element) => {
                        console.log(event.target.value)
                        console.log(element)
                        const newActions = currentActions.map((a, i) => i === index ? {...a, data: event.target.value} : a);
                        updateActions(newActions)
                    }

                    return (
                        <div className="builder-accordion-item" key={index}>
                            <input type="checkbox" id={`item-${index}`}/>
                            <label htmlFor={`item-${index}`}
                                   className="builder-accordion-header">{currentAction.name}</label>
                            <div className="builder-accordion-content">
                                <small className="form-text text-muted">{currentAction.description}</small>
                                {currentAction?.contents?.map((actionType, indexType) => {

                                    if (actionType.data_type === 'textarea') {
                                        return (<TextareaType key={`${indexType}-textarea`} element={actionType}
                                                              handleChange={handleChangeData}
                                                              defaultValue={action.data}/>)
                                    } else {
                                        return (<div>ToDo</div>)
                                    }
                                })}
                            </div>
                        </div>
                    )
                })}
            </div>
        </div>

    </div>)

}

export default Actions
