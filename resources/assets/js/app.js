require("./bootstrap");
import User from "./app/models/User";
import AuthMiddleware from "./app/middleware/AuthMiddleware";
const app = new Vue({
  el: "#app",
  router,
  data: {
    user: window.__set_user__,
    users: window.set_users,
    middleware: {},
    userLinks: [],
    icons: require("./app/library/Icons.json"),
    errors: false,
    register: false,
    newPassword: null,
    dark: true,
    csrf_token: token,
    url: window.url,
    page: null,
    route: null,
    loading: false
  },
  watch: {
    $route() {
      document.documentElement.scrollTop = 0;
      this.getHashRoute();
    },
    $user() {
      return new User(this, "user");
    },
    $middleware() {
      return new AuthMiddleware(this);
    }
  },
  computed: {
    company() {
      if (this.user) return this.user.company;
    }
  },
  created() {},
  mounted() {
    this.getHashRoute();
  },
  methods: {
    showLoader(message) {
      this.$refs.app.showLoader(message);
      this.$refs.login.showLoader(message);
    },
    getHashRoute() {
      var route = window.location.hash.split("#")[1];
      this.route = route;
      axios.post(`${this.url}/set_last_page`, {
        route: route
      });
    },
    getPage() {
      var route = window.location.hash.split("#")[1];
      this.loading = true;
      return axios.get(route).then(res => {
        this.page = res.data;
        this.loading = false;
      });
    }
  }
});
