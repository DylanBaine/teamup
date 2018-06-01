// User Views
import Login from '../views/auth/Login.vue';
import Home from '../views/Home.vue';

// Group Views
import Groups from '../views/groups/index.vue';
import CreateGroup from '../views/groups/create.vue';
import ShowGroup from '../views/groups/show.vue';

// Task Views
import Tasks from '../views/tasks/index.vue';
import CreateTask from '../views/tasks/create.vue';
import ShowTask from '../views/tasks/show.vue';

// Post Views
import PostType from '../views/posts/index.vue';
import Post from '../views/posts/show.vue';
import CreatePost from '../views/posts/create.vue';

const routes = [
    { path: '/', component: Home },
    {
        path: '/groups', component: Groups, children: [
            { path: 'create', component: CreateGroup },
            { path: ':group', component: ShowGroup },
        ]
    },
    {
        path: '/tasks', component: Tasks, children: [
            { path: 'create', component: CreateTask },
            { path: ':task', component: ShowTask },
        ]
    },
    {
        path: '/:type', component: PostType, children: [
            { path: 'create', component: CreatePost },
            { path: ':post', component: Post },
        ]
    }
]
export default routes;