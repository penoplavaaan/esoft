import React from 'react';
import ReactDOM from 'react-dom';
import Select from 'react-select'
import ToDoItem from "./ToDoItem";

function Card(props) {
    const options = [
        { value: 'vanilla', label: '---' },
        { value: 'chocolate', label: 'Date' },
        { value: 'strawberry', label: 'Responsible' }

    ]
    return (
        <div className="container-xl mt-5">
            <div className="row justify-content-end">
                <div className="col-md-3">
                    <Select options={options} />
                </div>
            </div>
            <div className="row justify-content-center">
                <div className="col-md-3">
                    <div className="card text-center">
                        <div className="card-header"><h2>To Do </h2></div>
                        <div className="card-body">
                            <ToDoItem header={"Подключить БД"} description={"Надо что-то сделать!"} dateOnCreate={"10.11.2021"} deadLine={"21.11.2021"}/>
                        </div>
                    </div>
                </div>
                <div className="col-md-3">
                    <div className="card text-center">
                        <div className="card-header"><h2>In Progress </h2></div>
                        <div className="card-body">
                            Task 1 <br/>
                            Task 2
                        </div>
                    </div>
                </div>
                <div className="col-md-3">
                    <div className="card text-center">
                        <div className="card-header"><h2>Done </h2></div>
                        <div className="card-body">
                            Task 1 <br/>
                            Task 2
                        </div>
                    </div>
                </div>

            <div className="col-md-3">
                <div className="card text-center">
                    <div className="card-header"><h2>Cancelled </h2></div>
                    <div className="card-body">
                        Task 1 <br/>
                        Task 2
                    </div>
                </div>
            </div>
        </div>
        </div>
    );
}

export default Card;

// DOM element
let user_block = document.getElementById('card-area');
if (user_block) {
    ReactDOM.render(<Card name="Boss"/>, user_block);
}
