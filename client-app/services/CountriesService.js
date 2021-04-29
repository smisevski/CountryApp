import axios from 'axios';

const BASE_URL = 'http://127.0.0.1:8000/'
// const HEADERS = {
//     'Content-Type': 'application/json',
//     'Access-Control-Allow-Origin': '*',
//     'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
//     'Authorization': `Bearer ${localStorage.accessToken}`
// };
export default class CountriesService {
    constructor() {

    }
    async getAll() {
        return axios.get(`${BASE_URL}countries`,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                    'Authorization': `Bearer ${localStorage.accessToken}`
                }
            },
        );
    }
    async addToFavorites(params) {
        return axios.post(`${BASE_URL}countries/favorites/add`,
            params,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                    'Authorization': `Bearer ${localStorage.accessToken}`
                }
            }
        );
    }
    async removeFromFavorites(params) {
        return axios.post(`${BASE_URL}countries/favorites/remove`,
            params,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                    'Authorization': `Bearer ${localStorage.accessToken}`
                }
            }
        );
    }
    async getFavorites() {
        return axios.get(`${BASE_URL}countries/favorites`,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                    'Authorization': `Bearer ${localStorage.accessToken}`
                }
            },
        );
    }
}