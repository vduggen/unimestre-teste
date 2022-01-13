import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";

const BASE_URL = "http://localhost/unimestre-backend/app";
const URL_VIACEP = "https://viacep.com.br/ws";

const ApiService = {
  init() {
    Vue.use(VueAxios, axios);
  },

  get(resource) {
    return Vue.axios
      .get(`${BASE_URL}/${resource}`)
      .catch((err) => err.response);
  },

  getViaCEP(CEP) {
    return Vue.axios.get(`${URL_VIACEP}/${CEP}/json/`).catch((err) => err);
  },

  post(resource, params) {
    return Vue.axios
      .post(`${BASE_URL}/${resource}`, params)
      .catch((err) => err.response);
  },

  put(resource, params) {
    return Vue.axios
      .put(`${BASE_URL}/${resource}`, params)
      .catch((err) => err.response);
  },

  delete(resource, params) {
    return Vue.axios
      .delete(`${BASE_URL}/${resource}`, params)
      .catch((err) => err.response);
  },
};

export default ApiService;
