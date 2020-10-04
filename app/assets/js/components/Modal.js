import React from 'react';
import styled from 'styled-components';

const Modal = styled.section`
  width: 100%;
  height: 100%;
  position: fixed;
  top:0;
  left: 0;
  right: 0;
  bottom: 0;
  background: #00000030;
  display: flex;
  justify-content: center;
  align-items: center;
`

export default (props) => {
    return (
        <Modal onClick={props.closeModal}>
            {props.children}
        </Modal>
    );
}