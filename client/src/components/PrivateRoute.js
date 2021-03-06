import React from "react";
import { Route, Redirect } from "react-router-dom";
import {useUser} from "../AuthContext";

// it redirects to "/" path (home page) if you do not have
// the permissions while trying to access a certain page
function PrivateRoute({ component: Component, ...rest }) {
	const {state} = useUser();
	const {isAuthenticated} = state;
	
	return (
		<Route
			{...rest}
			render={(props) => {
				return isAuthenticated ? <Component {...props} /> : <Redirect to="/Error403" />;
			}}
		/>
	);
}

export default PrivateRoute;
