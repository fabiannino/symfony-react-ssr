import React from 'react';
import ReactDOMServer from 'react-dom/server';
import { StaticRouter } from 'react-router-dom';

import App from '../App';

console.log(global.context)

const serverRenderer = () => {
  const context = {}
  console.log(ReactDOMServer.renderToString(
    <StaticRouter location={{ pathname: global.context.uri }} context={context}>
      <App />
    </StaticRouter>
  ))
}

serverRenderer();