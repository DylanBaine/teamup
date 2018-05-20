import Middleware from '../library/Middleware';
class AuthMiddleware extends Middleware {
    constructor(instance) {
        super(instance);
    }

    check() {
        if (this.$.AuthUser.email == null) {
            return this.$.$router.push('login');
        };
    }
}
export default AuthMiddleware;