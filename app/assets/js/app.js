// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import Page from "./page/Page";

class App extends React.Component {

    constructor(props: P, context: any) {
        super(props, context);
    }

    render() {
        return (
            <Page>
                <div style={{minHeight: 1000}}>

                </div>
            </Page>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('main'));
