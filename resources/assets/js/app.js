require('./bootstrap');
import User from './app/models/User';
import AuthMiddleware from './app/middleware/AuthMiddleware';
const app = new Vue({
    el: '#app',
    router,
    data: {
        user: window.__set_user__,
        middleware: {},
        userLinks: [],
    },
    watch: {
        $route() {
            document.documentElement.scrollTop = 0;
        },
        $user() {
            return new User(this, 'user');
        },
        $middleware() {
            return new AuthMiddleware(this);
        }
    },
    created() {
    },
    mounted() {

    },
    methods: {
        showLoader(message) {
            this.$refs.app.showLoader(message);
            this.$refs.login.showLoader(message);
        }
    },
});
