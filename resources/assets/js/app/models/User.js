import Model from '../library/Model';
class User extends Model {
    constructor(instance) {
        super();
        this.$ = instance;
        this.root = instance.$root;
    }

    getLoggedIn() {
        return axios.get(url + '/auth/user').then(res => {
            this.$.AuthUser = res.data;
            this.user = res.data;
        });
    }

    login(user) {
        return axios.post(url + '/auth/login', user)
            .then(res => {
                this.root.$router.push('/');
                this.$.handleResponse(res.data.user, res.data.error);
            });
    }

    logout() {
        return axios.post(url + '/auth/logout')
            .then(res => {
                this.root.$router.push('/login');
                this.root.AuthUser = "";
            })
    }

    exists() {
        return this.$.AuthUser.email !== null;
    }

}
export default User;