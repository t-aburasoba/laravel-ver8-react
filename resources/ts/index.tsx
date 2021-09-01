import React from 'react'
import ReactDom from 'react-dom'

const App = () => {
    return (
        <h1>Laravel SPA</h1>
    )
}

ReactDom.render(
    <App />,
    document.getElementById('app')
)