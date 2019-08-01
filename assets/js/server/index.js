require('ignore-styles');

require('@babel/register')({
  ignore: [/(node_modules)/],
  presets: ['@babel/preset-env', '@babel/preset-react']
})

// Add context var passed from the HomeController into the global
// so that it can be accessed from the React Component global.
global.context = context;

require('./server.js');