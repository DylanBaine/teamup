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
        icons: require('./app/library/Icons.json'),
        errors: false,
        register: false,
        newPassword: null,
        dark: true
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
    computed: {
        company() {
            if (this.user)
                return this.user.company
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
