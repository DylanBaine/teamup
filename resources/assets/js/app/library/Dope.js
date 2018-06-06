import Repository from './Repostory';
class Dope extends Repository {

    constructor(base) {

        super(base);

    }

    postMethod(route, data) {

        return axios.post(route, data);

    }



    getMethod(route) {

        return axios.get(route);

    }

}

export default Dope;