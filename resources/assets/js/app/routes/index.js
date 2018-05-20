var path = function (component) {
    return '../../pages/' + component;
}
import Foo from '../../pages/Foo.vue';
const routes = [
    { path: '/foo', component: Foo },
]
export default routes;