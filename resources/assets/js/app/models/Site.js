import Model from '../library/Model';
class Site extends Model {
    constructor(instance, store) {
        super({
            post: 'sites',
            get: 'sites'
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Site;