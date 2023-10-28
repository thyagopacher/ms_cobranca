import axios from "axios";

const api = axios.create({
  baseURL: "http://api.local/"
});

export default api;