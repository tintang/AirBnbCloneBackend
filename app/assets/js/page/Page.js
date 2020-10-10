import styled from 'styled-components';
import React, {useEffect, useState} from 'react';
import {UserProvider} from "../context/UserContext";
import {Navbar} from "../components/Navbar";
import {ScrollingProvider} from "../context/ScrollingContext";

const Page = styled.section`
    width: 100%;
    height: 100%;
`;

export default (props) => {
    const [user, setUser] = useState(sessionStorage.getItem('token'));
    const [scrollingPosition, setScrollingPosition] = useState(0);

    const setUserCallback = (user) => {
        sessionStorage.setItem('token', user);
        setUser(user);
    }

    const userContext = {
        user,
        setUser: setUserCallback
    };

    const scrollingContext = {
        scrollingPosition
    };

    useEffect(() => {
        window.addEventListener('wheel', (e) => {
            setScrollingPosition(window.scrollY);
        });
    }, []);

    return (
        <ScrollingProvider value={scrollingContext}>
            <UserProvider value={userContext}>
                <Page>
                    <Navbar isLoggedIn={!!user}/>
                    {props.children}
                </Page>
            </UserProvider>
        </ScrollingProvider>
    )
}