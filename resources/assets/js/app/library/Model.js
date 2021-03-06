import { throws } from "assert";

class Model {
  constructor(route, store) {
    this.postUrl = `${url}/${route.post}`;
    this.editUrl = route.edit ? `${url}/${route.edit}` : `${url}/${route.post}`;
    this.deleteUrl = route.delete
      ? `${url}/${route.delete}`
      : `${url}/${route.post}`;
    this.getUrl = `${url}/${route.get}`;
    this.instance = store.instance;
    this.store = store.store;
    this.model = this.constructor.name;
    this.setToDelete = null;
    this.url = url;
  }

  _set_(data) {
    this.instance[this.store] = data;
  }
  _get_(data) {
    return this.instance[this.store][data];
  }

  showLoader(message = "") {
    this.instance.$root.$refs.app.$refs.loader.run(message);
  }
  alert(message, type) {
    if (
      message == "Pleas log back in to continue working..." ||
      message == "Unauthenticated."
    ) {
      return (window.location.href = url + "/login");
    }
    if (message == "Set your new password to start working.") {
      return (window.location.href = url + "/set-password");
    }
    this.instance.$root.$refs.app.$refs.alert.run(message, type);
  }

  showError(message) {
    this.alert(message, "error");
  }

  successfullyAdded() {
    this.alert("Successfully added...", "info");
  }

  successfullyUpdated() {
    this.alert("Successfully updated...", "info");
  }

  successfullyDeleted() {
    this.instance.$root.$refs.app.$refs.alert.run(
      this.model + " was successfully deleted...",
      "info"
    );
  }

  prompt(content, buttons) {
    this.instance.$root.$refs.app.$refs.prompt.run(this, content, buttons);
  }

  where(param, value, first = null) {
    this.showLoader("Loading...");
    if (this.modelName != null) {
      this.model = this.modelName;
    }
    console.log(this.model);
    return axios
      .get(
        `${this.url}/search/?model=${this.model}&param=${param}&value=${value}`
      )
      .then(res => {
        this.showLoader();
        if (first == null) {
          this._set_(res.data);
        } else {
          this._set_(res.data[0]);
        }
      })
      .catch(err => {
        this.showLoader();
        this.showError(err.response.data.message);
      });
  }

  find(id) {
    this.showLoader(`Loading...`);
    return axios
      .get(`${this.getUrl}/${id}`)
      .then(res => {
        this.showLoader();
        this._set_(res.data);
      })
      .catch(err => {
        this.showLoader();
        this.showError(err.response.data.message);
      });
  }

  /**
   * Get all of the records of a given model
   */
  get(quick = false) {
    if (!quick) this.showLoader(`Loading...`);
    return axios
      .get(this.getUrl)
      .then(res => {
        if (!quick) this.showLoader();
        this._set_(res.data);
      })
      .catch(err => {
        if (!quick) this.showLoader();
        this.showError(err.response.data.message);
      });
  }

  has(relation) {
    return this._get_(relation);
  }

  /**
   * Add a new record to the database
   * @param {object} data the data to be saved for the object
   */
  create(data, config = null) {
    this.showLoader("Saving...");
    return axios
      .post(this.postUrl, data, config)
      .then(res => {
        this.successfullyAdded();
        this.showLoader();
        this.get();
      })
      .catch(err => {
        this.showError(err.response.data.message);
        this.showLoader();
      });
  }

  /**
   * Update a record in the database
   * @param {integer} id id of the record you are updating
   * @param {object} data the new data to be saved to the database
   */
  update(id, data, quick = false) {
    var config = {
      headers: { "Content-Type": "multipart/FormData" }
    };
    if (!quick) this.showLoader("Updating...");
    return axios
      .put(`${this.editUrl}/${id}`, data)
      .then(res => {
        if (!quick) this.showLoader();
        if (!quick) this.successfullyUpdated();
      })
      .catch(err => {
        if (!quick) this.showLoader();
        this.showError(err.response.data.message);
      });
  }

  /**
   * Delete a record fromt the database
   * @param {integer} id id of the record to delete
   */
  delete(id, callback = null) {
    this.setToDelete = id;
    this.callback = callback;
    var buttons = [
      { text: "Confirm", action: "performDelete", color: "error" },
      { text: "Cancel", action: "cancel", color: "primary" }
    ];
    this.prompt(
      `
      <h2 class="text-xs-center">Are you sure you want to delete this ${
        this.model
      }?</h2>
    `,
      buttons
    );
  }

  performDelete() {
    var id = this.setToDelete;
    this.showLoader("Deleting...");
    return axios
      .post(`${this.deleteUrl}/${id}`, { _method: "delete" })
      .then(res => {
        this.showLoader();
        this.successfullyDeleted();
        this.get();
        if (this.callback) {
          if (typeof this.callback == "string") {
            this.instance[this.callback]();
          } else {
            this.callback();
          }
        }
        this.setToDelete = null;
      })
      .catch(err => {
        this.showLoader();
        if (err) this.showError(err.response.data.message);
      });
  }
}
export default Model;
