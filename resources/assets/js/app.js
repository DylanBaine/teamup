require('./bootstrap');
import Group from './app/models/Group';
import User from './app/models/User';
const app = new Vue({
    el: '#app',
    router,
    data: {
        AuthUser: {},
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
    created() {

    },
    mounted() {
        let user = new User(this);
        user.getLoggedIn();
    },
    methods: {

    }
});
