import axios from "axios";

const axiosClient = axios.create({
    baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`,
});

// interceptors - functions executed before the req is send / after the response is received
// before making request
//config -object
axiosClient.interceptors.request.use((config) => {
    const token = localStorage.getItem("ACCESS_TOKEN");
    config.headers.Authorization = `Bearer ${token}`;
    return config;
});

// response interceptor
//use takes 2 functions as params
//1st on full filled
//2nd when rejected
axiosClient.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        const { response } = error;
        // if user is unauthorized
        // token expired or incorrect token
        if (response.status === 401) {
            localStorage.removeItem("ACCESS_TOKEN");
        } else {
            throw error;
        }
    }
);

export default axiosClient;
