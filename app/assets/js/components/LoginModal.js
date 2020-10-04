import Modal from "./Modal";
import styled from 'styled-components';
import React, {useContext} from 'react';
import {UserContext} from "../context/UserContext";
import {LoginForm} from "./LoginForm";


const LoginFormBody = styled.div`
 padding: 0 2% 2% 2%;
 width: 400px;
 background: white;
 border-radius: 8px;
`

const Header = styled.section`
  padding: 10px 0;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
`;

export default (props) => {
    return (
        <Modal closeModal={props.closeModal}>
            <LoginFormBody>
                <Header>
                    <h5 onClick={props.closeModal}>
                        Login
                    </h5>
                </Header>
                <UserContext.Consumer>
                    {({setUser}) => (
                        <LoginForm setUser={setUser} closeModal={props.closeModal}/>
                    )}
                </UserContext.Consumer>
            </LoginFormBody>
        </Modal>
    )
}