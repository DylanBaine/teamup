import Model from '../library/Model';
class PermissionMode extends Model {
    constructor(instance, store) {
        super({
            post: 'permission-modes',
            get: 'permission-modes'
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default PermissionMode;