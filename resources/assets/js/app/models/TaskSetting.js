import Model from '../library/Model';
class Task extends Model {
    constructor(instance, store) {
        super({
            post: 'settings?model=Task&id=' + instance[store].id,
            get: 'settings?model=Task&id=' + instance[store].id
        }, { instance, store });
        this.root = instance.$root;
    }

    addColumn(column) {
        axios.post(`${this.postUrl}&action=add-clumn`, column).then(res => {
            this.alert('Added a new column!', 'info');
        }).catch(err => {
            this.alert(err.response.data.message, 'error')
        });
    }

    subscribeUserToColumn(data) {
        axios.post(`${this.postUrl}&action=subscribe-user`, data).then(res => {
            this.alert('You subscribed a user to a row in this task!', 'info');
        }).catch(err => {
            this.alert(err.response.data.message, 'error');
        });
    }
}
export default Task;