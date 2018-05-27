import Model from '../library/Model';
class Group extends Model {
    constructor(instance, store) {
        super({
            post: 'groups',
            get: 'groups'
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Group;