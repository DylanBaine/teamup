// User Views
import Login from '../views/Login.vue';
import Home from '../views/Home.vue';

// Group Views
import Groups from '../views/groups/index.vue';
import CreateGroup from '../views/groups/create.vue';
import ShowGroup from '../views/groups/show.vue';

// Task Views
import Tasks from '../views/tasks/index.vue';
import CreateTask from '../views/tasks/create.vue';
import ShowTask from '../views/tasks/show.vue';
import ManageTask from '../views/tasks/manage.vue';
import EditTask from '../views/tasks/edit.vue';
import TaskSettings from '../views/tasks/settings.vue';

// Post Views
import PostType from '../views/posts/index.vue';
import Post from '../views/posts/show.vue';
import CreatePost from '../views/posts/create.vue';

// Permission Views
import Permissions from '../views/permissions/index.vue';
import CreatePermissions from '../views/permissions/create.vue';

const routes = [
    { path: '/login', component: Login },
    { path: '/', component: Home },
    {
        path: '/permissions', component: Permissions, children: [
            { path: 'create', component: CreatePermissions }
        ]
    },
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
        path: '/tasks/:task/manage', component: ManageTask, children: [
            { path: 'edit', component: CreateTask, meta: { editing: true } },
            { path: 'add-task', component: CreateTask },
            { path: 'settings', component: TaskSettings },
            {
                path: ':child', component: ShowTask, children: [
                    { path: 'edit', component: CreateTask, meta: { editing: true } },
                ]
            },
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