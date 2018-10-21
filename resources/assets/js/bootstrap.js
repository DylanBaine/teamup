window._ = require("lodash");
window.Popper = require("popper.js").default;

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
const token = document.head.querySelector('meta[name="csrf-token"]').content;
if (token) {
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}

/* import Echo from "laravel-echo";

window.Pusher = require("pusher-js");

window.Echo = new Echo({
  broadcaster: "pusher",
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  encrypted: true
}); */

window.Vue = require("vue");

import VueRouter from "vue-router";
Vue.use(VueRouter);
import routes from "./app/routes";
window.router = new VueRouter({
  routes
});

import Vuetify from "vuetify";
import colors from "vuetify/es5/util/colors";
Vue.use(Vuetify, {
  theme: {
    primary: colors.teal.lighten1.toString(),
    accent: colors.pink.base.toString(),
    error: colors.red.base.toString(),
    warning: colors.orange.accent3.toString(),
    success: colors.green.accent4.toString()
  }
});

import VueGoogleCharts from "vue-google-charts";
Vue.use(VueGoogleCharts);

Vue.component("application", require("./views/Application.vue"));
Vue.component("login", require("./views/auth/Login.vue"));
Vue.component("loader", require("./components/Loader.vue"));
Vue.component("icon-selector", require("./components/IconSelector.vue"));
Vue.component("alerts", require("./components/Alert.vue"));
Vue.component("draggable", require("vuedraggable"));
Vue.component("user-manage-modal", require("./components/UserManageModal.vue"));
Vue.component("page-builder", require("./components/PageBuilder.vue"));
Vue.component("register", require("./views/auth/Register.vue"));
Vue.component("prompt", require("./components/Prompt.vue"));

Vue.component("pie-chart", require("./components/PieChart.vue"));
Vue.component("bar-chart", require("./components/BarChart.vue"));
Vue.component("generic-chart", require("./components/GenericChart.vue"));

Vue.component("basic-task-report", require("./components/BasicTaskReport.vue"));
Vue.component("project-report", require("./components/ProjectReport.vue"));

Vue.component("task-calendar", require("./components/Calendar.vue"));

Vue.component("task-preview", require("./views/tasks/show.vue"));
Vue.component("task-settings", require("./views/tasks/settings.vue"));
Vue.component("add-post-type", require("./views/posts/manage.vue"));
Vue.component("task-breadcrumb", require("./components/TaskBreadcrumb.vue"));

Vue.component("file-preview", require("./views/files/show"));

Array.prototype.hasProp = function(needle, haystack) {
  for (let i = 0; i < this.length; i++) {
    var el = this[i];
    if (needle == el[haystack]) {
      return true;
    }
  }
  return false;
};

String.prototype.isHTML = function() {
  let str = this;
  var a = document.createElement("div");
  a.innerHTML = str;

  for (var c = a.childNodes, i = c.length; i--; ) {
    if (c[i].nodeType == 1) return true;
  }

  return false;
};

String.prototype.shorten = function(chars = null) {
  var _chars = chars == null ? 400 : chars;
  return this.substr(0, _chars);
};
