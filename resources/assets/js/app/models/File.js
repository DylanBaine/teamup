import Model from "../library/Model";
class File extends Model {
  constructor(instance, store) {
    super(
      {
        post: "files",
        get: "files"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default File;
