import axios from 'axios';

const BASE_URL = 'http://127.0.0.1:8000/'

export default class AuthService {
    constructor() {

    }
    async call() {

    }
    async login(params) {
        console.log('post params: ', params);
        return axios.post(`${BASE_URL}login`,
            params,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods' : 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                }
            },
        );
    }
    async logout() {

    }
}