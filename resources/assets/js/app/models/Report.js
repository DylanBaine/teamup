import Model from "../library/Model";
class Report extends Model {
  constructor(instance, store) {
    super(
      {
        post: "reports",
        get: "reports"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default Report;
