class Model {
    constructor(route, store) {
        this.postUrl = `${url}/${route.post}`;
        this.editUrl = route.edit ? `${url}/${route.edit}` : `${url}/${route.post}`;
        this.getUrl = `${url}/${route.get}`;
        this.instance = store.instance;
        this.store = store.store;
        this.model = this.constructor.name;
    }

    _set_(data) {
        this.instance[this.store] = data;
    }
    _get_(data) {
        return this.instance[this.store][data];
    }

    showLoader(message = '') {
        this.instance.$root.$refs.app.$refs.loader.run(message);
    }
    alert(message, type) {
        if (message == "Pleas log back in to continue working...") {
            return this.instance.$root.$refs.app.$refs.alert.run(message, 'error', '/login');
        }
        this.instance.$root.$refs.app.$refs.alert.run(message, type);
    }

    showError(message) {
        this.alert(message, 'error');
    }

    successfullyAdded() {
        this.alert('Successfully added...', 'info');
    }

    successfullyUpdated() {
        this.alert('Successfully updated...', 'info');
    }

    successfullyDeleted() {
        this.instance.$root.$refs.app.$refs.alert.run('Task was successfully deleted...', 'info');
    }

    /**
     * Search the model in the database
     * @param {string} variable the property the result is to be stored in
     * @param {string} param parameter we are searching for
     * @param {sting|integer} value value of the parameter
     */
    where(param, value, first = null) {
        this.showLoader('Loading...');
        return axios.get(`${url}/search/?model=${this.model}&param=${param}&value=${value}`)
            .then(res => {
                this.showLoader();
                if (first == null) {
                    this._set_(res.data);
                } else {
                    this._set_(res.data[0]);
                }
            }).catch(err => {
                this.showLoader();
                this.showError(err.response.data.message);
            });
    }

    /**
     * Find the first record that matches the parameter give.
     * @param {sting} param the parameter in the database we are searching for.
     * @param {value} value the value the parameter should match
     */
    /*     find(param, value) {
            this.showLoader(`Loading...`);
            return axios.get(`${url}/search/?model=${this.model}&param=${param}&value=${value}`)
                .then(res => {
                    this.showLoader();
                    this._set_(res.data[0]);
                });
        } */

    find(id) {
        this.showLoader(`Loading...`);
        return axios.get(`${this.getUrl}/${id}`)
            .then(res => {
                this.showLoader();
                this._set_(res.data);
            }).catch(err => {
                this.showLoader();
                this.showError(err.response.data.message);
            });
    }

    /**
     * Get all of the records of a given model
     */
    get() {
        this.showLoader(`Loading...`);
        return axios.get(this.getUrl)
            .then(res => {
                this.showLoader();
                this._set_(res.data);
            }).catch(err => {
                this.showLoader();
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
    create(data) {
        var config = {
            headers: { 'Content-Type': 'multipart/FormData' }
        };
        this.showLoader('Saving...');
        return axios.post(this.postUrl, data)
            .then(res => {
                this.successfullyAdded();
                this.showLoader();
                this.get();
            }).catch(err => {
                this.showError(err.response.data.message);
                this.showLoader();
                console.log(err.response.data.message);
            });
    }

    /**
     * Update a record in the database
     * @param {integer} id id of the record you are updating
     * @param {object} data the new data to be saved to the database
     */
    update(id, data, quick = false) {
        var config = {
            headers: { 'Content-Type': 'multipart/FormData' }
        };
        if (!quick) this.showLoader('Updating...');
        return axios.put(`${this.editUrl}/${id}`, data)
            .then(res => {
                if (!quick) this.showLoader();
                if (!quick) this.successfullyUpdated();
            }).catch(err => {
                if (!quick) this.showLoader();
                this.showError(err.response.data.message);
            });;
    }

    /**
     * Delete a record fromt the database
     * @param {integer} id id of the record to delete
     */
    delete(id) {
        this.showLoader('Deleting...');
        return axios.post(`${this.postUrl}/${id}`, {
            _method: 'delete'
        }).then(res => {
            this.showLoader();
            this.successfullyDeleted();
            this.get();
        }).catch(err => {
            this.showLoader();
            this.showError(err.response.data.message);
        });
    }
}
export default Model;