require('./bootstrap');
import User from './app/models/User';
import AuthMiddleware from './app/middleware/AuthMiddleware';
const app = new Vue({
    el: '#app',
    router,
    data: {
        user: {},
        middleware: {},
        AuthUser: "",
        dialog: false,
        drawer: null,
        userLinks: [],
        items: [
            { icon: 'contacts', text: 'Contacts' },
            { icon: 'history', text: 'Frequently contacted' },
            { icon: 'content_copy', text: 'Duplicates' },
            {
                icon: 'keyboard_arrow_up',
                'icon-alt': 'keyboard_arrow_down',
                text: 'Labels',
                model: true,
                children: [
                    { icon: 'add', text: 'Create label' }
                ]
            },
            {
                icon: 'keyboard_arrow_up',
                'icon-alt': 'keyboard_arrow_down',
                text: 'More',
                model: false,
                children: [
                    { text: 'Import' },
                    { text: 'Export' },
                    { text: 'Print' },
                    { text: 'Undo changes' },
                    { text: 'Other contacts' }
                ]
            },
            { icon: 'settings', text: 'Settings' },
            { icon: 'chat_bubble', text: 'Send feedback' },
            { icon: 'help', text: 'Help' },
            { icon: 'phonelink', text: 'App downloads' },
            { icon: 'keyboard', text: 'Go to the old version' }
        ]
    },
    watch: {
        $route() {
            this.middleware.check();
        }
    },
    created() {
        this.user = new User(this);
        this.middleware = new AuthMiddleware(this);
    },
    mounted() {
        this.middleware.check();
        this.user.getLoggedIn();
    },
    methods: {

    },
});
