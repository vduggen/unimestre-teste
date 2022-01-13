import Vue from "vue";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import VueMask from "v-mask";
import router from "./router";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import ApiService from "@/core/services/api.service";

ApiService.init();
Vue.use(Toast, {});
Vue.use(VueMask);

Vue.config.productionTip = false;

new Vue({
  vuetify,
  router,
  render: (h) => h(App),
}).$mount("#app");
