import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8080/api',  // Ensure this matches your backend URL
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
  }
});

export default instance;
