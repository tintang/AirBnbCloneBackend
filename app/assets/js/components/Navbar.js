import React, {useContext, useState} from 'react';
import styled from 'styled-components'
import LoginModal from "./LoginModal";
import logo from "../../img/pngegg.png";
import NavbarSearchForm from "./NavbarSearchForm";
import {ScrollingContext} from "../context/ScrollingContext";

const NavbarContainer = styled.nav`
    background: white;
    padding: 1%  40px;
    box-sizing: border-box;
    position: ${props =>
    props.scrollPosition > 60 ? 'fixed' : 'inherit'
};
    width:100%;
    display: grid;
    grid-template-columns: 25% 50% 25%;
`

const NavbarLeft = styled.div`
    justify-self: left;
`;

const NavbarCenter = styled.div`
  justify-self: center;
  align-self: center;
  width: 80%;
`

const NavbarRight = styled.div`
  justify-self: right;
  align-self: center;
`;

const NavbarList = styled.ul`
  list-style-type: none;
  margin:0;
  display: flex;
`;

const NavbarListItem = styled.li`
  display: inline-flex;
  height: 30px;
  align-items: center;
  justify-content: center;
  padding: 3px 25px;
  font-size: 1rem;
  border-radius: 20px;
  &:hover {
    background: rgb(247, 247, 247) !important;
  }
`;

export const Navbar = (props: PropTypes) => {
    const [isLoginModalOpen, setIsLoginModalOpen] = useState(false);
    const scrollingContext = useContext(ScrollingContext);

    const toggleModal = (e: Event) => {
        if (e.target === e.currentTarget) {
            setIsLoginModalOpen(!isLoginModalOpen);
        }
    };

    return (
        <NavbarContainer
            scrollPosition={scrollingContext.scrollingPosition}>
            <NavbarLeft>
                <img src={logo} height={50} alt={"logo"}/>
            </NavbarLeft>
            <NavbarCenter>
                <NavbarSearchForm/>
            </NavbarCenter>
            <NavbarRight>
                {props.isLoggedIn ?
                    (
                        <NavbarList>
                            <NavbarListItem>Meine Angebote</NavbarListItem>
                            <NavbarListItem>Mein Profil</NavbarListItem>
                            <NavbarListItem>Meine Buchungen</NavbarListItem>
                        </NavbarList>

                    ) :
                    (
                        <NavbarList>
                            <NavbarListItem onClick={toggleModal}>Login</NavbarListItem>
                        </NavbarList>
                    )
                }
            </NavbarRight>
            {isLoginModalOpen && <LoginModal closeModal={toggleModal}/>}
        </NavbarContainer>
    )
};

