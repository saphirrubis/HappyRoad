import './app/assets/styles/index.css';
import 'react-toastify/dist/ReactToastify.css';

import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';

import Switcher from './app/components/darkMode/Switcher';

import App from './app/App';
import { store } from './app/redux-store/store';

ReactDOM.render(
    <React.StrictMode>
        <Provider store={store}>
            <App />
        </Provider>
    </React.StrictMode>,
    document.getElementById('root'),
);
