import Model from "../library/Model";
class Task extends Model {
  constructor(instance, store) {
    super(
      {
        post: "tasks",
        get: "tasks"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default Task;
