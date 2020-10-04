import React from 'react';
import styled from "styled-components";
import input from "../generic_components/input";
import {useFormik} from "formik";

const NavbarSearchInput = styled(input)`
  margin: 0 auto;
  width:80%;
  border-radius: 15px;
  height: 25px;
  text-indent: 15px;
  display: block;
`;

export default (props) => {


    const formik = useFormik({
        initialValues: {
            query: ''
        },
        onSubmit: (values) => {
            fetch("http://localhost", {
                body: JSON.stringify(values),
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then((res) => res.json())
                .then((body) => {

                })
                .catch((err) => console.log)
        }
    });

    return (
        <form onSubmit={formik.handleSubmit}>
            <NavbarSearchInput
                onChange={formik.handleChange}
                value={formik.values.query}
                name={"query"}
                placeholder={"Wo wollen Sie hin?"}/>
        </form>
    );
}