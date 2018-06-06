import Model from '../library/Model';
class Type extends Model {
    constructor(instance, store) {
        super({
            post: 'types?model=Post',
            get: 'types?model=Post',
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Type;