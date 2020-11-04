import axios from 'axios';

const client = axios.create({
  baseURL: 'https://viacep.com.br/ws/',
});

export default {
  get( postcode ) {
    return client.get( postcode + '/json' );
  },
};