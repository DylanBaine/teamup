import Dope from '../library/Dope';
class Group extends Dope {
    constructor(instance, store) {
        super('groups');
        /* super({
            post: 'groups',
            get: 'groups'
        }, { instance, store });
        this.root = instance.$root; */
    }
}
export default Group;