import React from 'react';

export const ScrollingContext = React.createContext({
    scrollXPosition: 0,
    scrollYPosition: 0,
});

export const ScrollingProvider = ScrollingContext.Provider;
export const ScrollingConsumer = ScrollingContext.Consumer;