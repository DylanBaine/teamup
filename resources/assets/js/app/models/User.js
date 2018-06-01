import Model from '../library/Model';
class User extends Model {
    constructor(instance, store) {
        super({
            post: 'users',
            get: 'users',
        }, { instance, store });
        this.root = instance.$root;
    }

    login(user) {
        this.instance.showLoader('Logging you in...');
        return axios.post(url + '/auth/login', user)
            .then(res => {
                this.instance.showLoader();
                this.root.user = res.data;
            });
    }

    logout() {
        this.instance.showLoader('Logging you out...');
        return axios.post(url + '/auth/logout')
            .then(res => {
                this.instance.showLoader();
                this.root.user = false;
            })
    }

    permissions(mode = null) {
        if (mode !== null) {
            return this.has('permissions').filter(permission => permission.permission_mode.name == mode);
        } else {
            return this.has('permissions');
        }
    }

    can(action, type) {
        var permission = this.permissions(action);
        return permission[0].types.hasProp(type, 'slug');
    }

}
export default User;