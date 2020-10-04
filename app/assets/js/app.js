/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import {UserProvider} from "./context/UserContext";
import {Navbar} from "./components/Navbar";

const AppBody = styled.section`
    width: 100%;
    height: 100%;
`;

class App extends React.Component {

    constructor(props: P, context: any) {
        super(props, context);
        this.state = {
            user: null,
            setUser: this.setUser.bind(this),
            isLoggedIn: false
        }
    }

    setUser(user) {
        this.setState({
            user: user,
            isLoggedIn: true
        });
    }

    render() {
        return (
            <AppBody>
                <UserProvider value={this.state}>
                    <Navbar isLoggedIn={this.state.isLoggedIn}/>
                </UserProvider>
            </AppBody>
        );
    }
}

ReactDOM.render(<App/>, document.getElementById('main'));
