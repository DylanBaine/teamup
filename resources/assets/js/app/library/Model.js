class Model {
    constructor() {
        this.model = this.constructor.name;
        this.modelUrl = this.model.toLowerCase() + "s";
        this.modelBaseRoute = `${url}/${this.modelUrl}`;
    }

    /**
     * Search the model in the database
     * @param {string} variable the property the result is to be stored in
     * @param {string} param parameter we are searching for
     * @param {sting|integer} value value of the parameter
     */
    where(variable, param, value) {
        return axios.get(`${url}/search/?model=${this.model}&param=${param}&value=${value}`)
            .then(res => {
                this.$[variable] = res.data;
            });
    }

    /**
     * Get all of the records or a specific record of a given model
     * @param {string} variable the property the result is to be stored in
     * @param {integer|nullable} id the id of the specific rcord you want to return
     */
    get(variable, id = null) {
        var route = id == null ? this.modelBaseRoute : `${this.modelBaseRoute}/${id}`;
        return axios.get(route)
            .then(res => {
                this.$[variable] = res.data
            });
    }

    /**
     * Add a new record to the database
     * @param {object} data the data to be saved for the object
     */
    create(data) {
        var config = {
            headers: { 'Content-Type': 'multipart/FormData' }
        };
        return axios.post(this.modelBaseRoute, data, config);
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
        return axios.put(`${this.modelBaseRoute}/${id}`, data, config);
    }

    /**
     * Delete a record fromt the database
     * @param {integer} id id of the record to delete
     */
    delete(id) {
        return axios.post(`${this.modelBaseRoute}/${id}`, {
            _method: 'delete'
        })
    }
}
export default Model;