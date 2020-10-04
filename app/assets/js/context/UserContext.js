import React from 'react';

export const UserContext = React.createContext({
    user: null,
    setUser: (user) => {
        this.user = user
    }
});

export const UserProvider = UserContext.Provider;