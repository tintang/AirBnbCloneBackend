import React, {useContext} from 'react';
import {useFormik} from "formik";
import Button from "../generic_components/button";
import styled from "styled-components";
import Input from "../generic_components/input";
import {UserContext} from "../context/UserContext";
import AuthenticationApi from "../api/AuthenticationApi";

const LoginFormElement = styled.form`
 background: white;
 display: flex;
 flex-direction: column;
`;


const LoginInput = styled(Input)`

`;


export const LoginForm = (props: ConsumerProps) => {

    const formik = useFormik(
        {
            initialValues: {
                'email': '',
                'password': '',
            },
            onSubmit: values => {
                AuthenticationApi.login(values, props.setUser);
            }
        }
    );

    const onLoginSubmit = (e: Event) => {
        formik.handleSubmit(e);
        props.closeModal(e);
    }

    return (
        <LoginFormElement onSubmit={onLoginSubmit}>
            <LoginInput value={formik.values.email} onChange={formik.handleChange} placeholder="email"
                        name="email"/>
            <LoginInput value={formik.values.password} name="password" onChange={formik.handleChange}
                        placeholder="password" type="password"/>
            <Button type="submit">OK</Button>
        </LoginFormElement>
    )
}