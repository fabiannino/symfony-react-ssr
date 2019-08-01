import React from 'react';
import { Route, Switch, NavLink } from 'react-router-dom';

import Home from './Home';
import Posts from './Posts';

const App = () => {
  return (
    <div>
      <ul>
        <li>
          <NavLink to="/home">Home</NavLink>
        </li>
        <li>
          <NavLink to="/posts">Posts</NavLink>
        </li>
      </ul>

      <Switch>
        <Route
          exact
          path="/"
          render={props => <Home name="Fabian" {...props} />}
        />
        <Route path="/home" component={Home} />
        <Route path="/posts" component={Posts} />
      </Switch>
    </div>
  );
}

export default App;