class Repository {

    constructor(url) {

        this.collection = [];

        this._where = [];

        this._take = false;

        this._select = [];

        this.baseUrl = typeof url === "undefined" ? this.constructor.name.toLowerCase() + 's' : url;

    }



    selectParams() {

        var select = '&select=';

        this._select.forEach(item => {

            string += `${item},`;

        });

        return select;

    }



    whereParams() {

        var where = '&';

        this._where.forEach((item, i) => {

            where += `${item.param}=${item.val}`;

            if (i != this._where.length - 1) where += '&';

        });

        return where;

    }



    queryParams() {

        var fullRoute = '?';

        this._where.length ? (fullRoute += this.whereParams()) : '';

        this._select.length ? (fullRoute += this.selectParams()) : '';

        this._take ? (fullRoute += "&take=" + this._take) : '';

        return fullRoute;

    }



    collectionOfChildClass(data) {

        var response = [];

        data.forEach(result => {

            var freshInstance = new this.constructor();

            freshInstance.set(result);

            response.push(freshInstance);

        });

        this.collection = response;

    }



    setFillableProps(data) {

        this.fillable.forEach(prop => {

            this[prop] = data[prop];

        });

    }



    set(data) {

        if (typeof data.length !== 'undefined') {

            return this.collectionOfChildClass(data);

        }

        if (this.fillable) {

            return this.setFillableProps(data);

        }

        for (let prop in data) {
            this[prop] = data[prop];
        }

    }



    makeRequest(method, data = null) {

        var url = `${this.baseUrl}${this.queryParams()}`;

        method(url, data).then(res => {

            this.set(res.data);

        });

        return this;

    }



    update(data) {

        this.makeRequest(this.updateMethod(data));

        return this;

    }



    create(data) {

        this.makeRequest(this.postMethod(data));

        return this;

    }



    get() {

        return this.makeRequest(this.getMethod);

    }



    take(num) {

        this._take = num;

        return this;

    }



    first() {

        this._take = 1;

        return this.get();

    }



    where(param, val) {

        this._where.push({ param: param, val: val });

        return this;

    }



    select(arr) {

        this._select = arr;

    }

}



export default Repository;