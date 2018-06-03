class Model {
    constructor(route, store) {
        this.postUrl = `${url}/${route.post}`;
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

    /**
     * Search the model in the database
     * @param {string} variable the property the result is to be stored in
     * @param {string} param parameter we are searching for
     * @param {sting|integer} value value of the parameter
     */
    where(param, value, first = null) {
        return axios.get(`${url}/search/?model=${this.model}&param=${param}&value=${value}`)
            .then(res => {
                if (first == null) {
                    this._set_(res.data);
                } else {
                    this._set_(res.data[0]);
                }
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
        console.log(this.postUrl)
        return axios.post(this.postUrl, data)
            .then(res => {
                this.showLoader();
                this.get();
            }).catch(err => {
                this.showLoader();
                console.log(err.message);
            });
    }

    /**
     * Update a record in the database
     * @param {integer} id id of the record you are updating
     * @param {object} data the new data to be saved to the database
     */
    update(id, data) {
        var config = {
            headers: { 'Content-Type': 'multipart/FormData' }
        };
        return axios.put(`${this.postUrl}/${id}`, data);
    }

    /**
     * Delete a record fromt the database
     * @param {integer} id id of the record to delete
     */
    delete(id) {
        return axios.post(`${this.postUrl}/${id}`, {
            _method: 'delete'
        })
    }
}
export default Model;