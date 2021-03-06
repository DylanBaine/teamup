import Model from "../library/Model";
class User extends Model {
  constructor(instance, store) {
    super(
      {
        post: "users",
        get: "users"
      },
      { instance, store }
    );
    this.root = instance.$root;
  }

  login(user) {
    this.instance.showLoader("Logging you in...");
    return axios
      .post(url + "/auth/login", user)
      .then(res => {
        window.location.href = "/app";
      })
      .catch(err => {
        this.instance.showLoader();
        this.instance.error = err.response.data.message;
        if (!err.response.data.message) {
          window.location.reload();
        }
      });
  }

  register(user) {
    this.instance.showLoader("Setting things up...");
    return axios
      .post(url + "/auth/register", user)
      .then(res => {
        window.location.href = "/app";
        this.root.user = res.data;
      })
      .catch(err => {
        this.instance.showLoader();
        this.instance.error = err.response.data.message;
        if (!err.response.data.message) {
          window.location.reload();
        }
      });
  }

  logout() {
    this.instance.showLoader("Logging you out...");
    return axios.post(url + "/auth/logout").then(res => {
      this.instance.showLoader();
      this.root.user = false;
      window.location.href = "/";
    });
  }

  permissions(mode = null) {
    if (mode !== null && this.has("permissions")) {
      return this.has("permissions").filter(
        permission => permission.mode.name == mode
      );
    } else {
      return this.has("permissions");
    }
  }

  can(action, type) {
    var permissions = this.permissions(action);
    if (permissions) {
      return (
        permissions.filter(permission => {
          return permission.type.slug == type;
        }).length > 0
      );
    }
  }
}
export default User;
