import axios from 'axios';

const URL_BASE = 'http://127.0.0.1:8000/api/';

export function getConfig() {
  return {
    "headers": {
      "Content-type": "application/json",
      "Authorization": `Bearer ${sessionStorage.getItem('token')}`,
    }
  };
}

export function login(email, password) {
  return axios.post(URL_BASE + `auth/login`, {
    email: email,
    password: password
  }).then(response => {
    return response.data.access_token;
  }).catch(error => {
    throw error;
  });
}

export function register(name, email, password) {
  return axios.post(URL_BASE + `auth/register`, {
    name: name,
    email: email,
    password: password
  }).then(response => {
    return response;
  }).catch(error => {
    throw error;
  });
}

export function getData(path) {
  return axios.get(URL_BASE + path, getConfig())
    .then(response => {
      return response.data;
    }).catch(error => {
      return error;
    });
}

export function postData(path, body) {
  return axios.post(URL_BASE + path, body, getConfig())
  .then(response => {
    return response.data;
  }).catch(error => {
    return error;
  });
}