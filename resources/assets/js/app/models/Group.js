import Model from '../library/Model';
class Group extends Model {
    constructor(instance) {
        super();
        this.$ = instance;
    }
}
export default Group;