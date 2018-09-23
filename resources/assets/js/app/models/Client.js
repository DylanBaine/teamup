import Model from "../library/Model";
class Client extends Model {
  constructor(instance, store) {
    super(
      {
        post: "clients",
        get: "clients"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }
}
export default Client;
