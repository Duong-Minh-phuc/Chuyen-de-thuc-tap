import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost:8000/api",
});

// Xử lý lỗi trả về từ server
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      window.location.href = "/Login";
    }
    return Promise.reject(error);
  }
);

export default axiosInstance;
