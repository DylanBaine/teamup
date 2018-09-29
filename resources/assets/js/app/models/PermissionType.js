import Model from "../library/Model";
class PermissionType extends Model {
  constructor(instance, store) {
    super(
      {
        post: "types",
        get: "types"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default PermissionType;
