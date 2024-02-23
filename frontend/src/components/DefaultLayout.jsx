import { Link, Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";
import axiosClient from "../axios-client";

const DefaultLayout = () => {
    const { user, token, setUser, setToken } = useStateContext();
    console.log(user);
    console.log(token);
    if (!token) {
        return <Navigate to="/login" />;
    }

    const onLogout = () => {
        axiosClient.post("/logout").then(() => {
            setUser({});
            setToken(null);
        });
    };

    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/dashboard">Dashboard</Link>
                <Link to="/users">Users</Link>
            </aside>
            <div className="content">
                <header>
                    <div>Header</div>
                    <div>
                        {user?.name}
                        <Link onClick={onLogout} className="btn-logout">
                            Logout
                        </Link>
                    </div>
                </header>
                <main>
                    <Outlet />
                </main>
            </div>
        </div>
    );
};
export default DefaultLayout;
