import Model from '../library/Model';
class Post extends Model {
    constructor(instance, store) {
        super({
            post: 'posts',
            get: 'posts',
        }, { instance, store });
        this.root = instance.$root;
    }
}
export default Post;