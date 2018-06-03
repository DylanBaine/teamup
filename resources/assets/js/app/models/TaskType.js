import Model from '../library/Model';
class TaskType extends Model {
    constructor(instance, store) {
        super({
            post: 'types?model=Task',
            get: 'types?model=Task',
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default TaskType;