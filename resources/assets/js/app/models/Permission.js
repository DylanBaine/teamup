import Model from '../library/Model';
class Permission extends Model {
    constructor(instance, store) {
        super({
            post: 'permissions',
            get: 'permissions',
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Permission;