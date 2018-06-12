import Model from '../library/Model';
class Task extends Model {
    constructor(instance, store) {
        super({
            post: 'settings?model=Task&id=' + instance[store].id,
            get: 'settings?model=Task&id=' + instance[store].id,
            edit: 'settings'
        }, { instance, store });
        this.root = instance.$root;
    }

    subscribeUserToTask(data) {
        return axios.post(`${this.postUrl}&action=subscribe-user-to-task`, data).then(res => {
            this.alert('User subscribed to this task.', 'info');
        }).catch(err => {
            this.alert(err.response.data.message, 'error');
        });
    }

    addColumn(column) {
        return axios.post(`${this.postUrl}&action=add-column`, column).then(res => {
            this.alert('Added a new column!', 'info');
        }).catch(err => {
            this.alert(err.response.data.message, 'error')
        });
    }

    removeSubscriber(setting) {
        return axios.post(`${this.postUrl}&action=remove-user-from-column&arg=${setting}`).then(res => {
            this.alert('User subscribed.', 'info');
        }).catch(err => {
            this.alert(err.response.data.message, 'error');
        });
    }

    removeColumn(column) {
        return axios.post(`${this.postUrl}&action=remove-column&arg=${column}`)
    }
}
export default Task;