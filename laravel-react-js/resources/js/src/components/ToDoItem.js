import Select from "react-select";
import React from "react";
import Card from "./Card";

function ToDoItem(props) {
    return (
        <div className="card">
            <div className="card-header">
                <h4>
                    {props.header}
                </h4>
                <h6 className="card-subtitle mb-2 text-muted">
                    DateOnCreate: {props.dateOnCreate}
                </h6>
                <h6 className="card-subtitle mb-2 text-muted">
                    DeadLine: {props.deadLine}
                </h6>
            </div>
            <div className="card-body">
                <div className="card-title">
                    {props.description}
                </div>

            </div>
        </div>

    );
}

export default ToDoItem;
