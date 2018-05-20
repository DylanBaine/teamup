import Model from '../library/Model';
class User extends Model {
    constructor(instance) {
        super();
        this.$ = instance;
    }

    loggedIn() {
        return axios.get('auth-user').then(res => {
            this.$.AuthUser = res.data;
        });
    }

}
export default User;