import Model from "../library/Model";
class Group extends Model {
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

  addUser(id) {
    return axios
      .post(this.postUrl + "/manage/users/" + id, {
        group: this.instance[this.store].id
      })
      .catch(err => {
        this.showError(err.response.data.message);
      });
  }

  removeUser(userId) {
    return axios.post(
      this.postUrl + "/" + this.instance[this.store].id + "/remove/" + userId,
      {
        _method: "delete"
      }
    );
  }
}
export default Group;
