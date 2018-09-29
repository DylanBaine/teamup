import Model from "../library/Model";
class TaskType extends Model {
  constructor(instance, store) {
    super(
      {
        post: "types?model=Task",
        get: "types?model=Task",
        edit: "types"
      },
      { instance, store }
    );
    this.modelName = "Type";
  }
}
export default TaskType;
