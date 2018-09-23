import Model from '../library/Model';
class Contact extends Model {
    constructor(instance, store) {
        super({
            post: 'contacts',
            get: 'contacts'
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Contact;
