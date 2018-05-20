class Middleware {
    constructor(instance) {
        this.$ = instance.$root;
    }
}
export default Middleware;