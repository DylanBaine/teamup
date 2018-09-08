import Dope from "../library/Model";
class Group extends Dope {
  constructor(instance, store) {
    super(
      {
        post: "groups",
        get: "groups"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default Group;
