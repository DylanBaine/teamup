import Model from "../library/Model";
class PostType extends Model {
  constructor(instance, store) {
    super(
      {
        post: "types?model=Post",
        get: "types?model=Post",
        edit: "types",
        delete: "types"
      },
      { instance, store }
    );
    this.root = instance.$root;
    this.modelName = "Type";
  }
}
export default PostType;
