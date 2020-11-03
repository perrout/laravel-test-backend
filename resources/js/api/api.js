import axios from 'axios';

const client = axios.create({
  baseURL: '/api',
});

export default {
  all( url, params ) {
    return client.get( url, params );
  },
  create( url, data ) {
    return client.post( url, data );
  },
  find( url, id ) {
    return client.get( `${url}/${id}`);
  },
  update(  url, id, data ) {
    return client.put(`${url}/${id}`, data);
  },
  delete( url, id ) {
    return client.delete(`${url}/${id}`);
  },
};