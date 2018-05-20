import Middlware from '../library/Middleware';
class GuestMiddleware extends Middlware {
    constructor(instance) {
        super(instance);
    }
    check() {
        if (this.$.AuthUser.email) {
            return this.$.$router.push('/');
        }
    }
}
export default GuestMiddleware;