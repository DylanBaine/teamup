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
//import EditTask from '../views/tasks/edit.vue';
import TaskSettings from '../views/tasks/settings.vue';

// Post Views
import PostType from '../views/posts/type.vue';
import ShowPost from '../views/posts/show.vue';
import CreatePost from '../views/posts/create.vue';
import ManagePosts from '../views/posts/manage.vue';
import PostTypess from '../views/posts/index.vue';

// Permission Views
import Permissions from '../views/permissions/index.vue';
import CreatePermissions from '../views/permissions/create.vue';

// Site Views
import Sites from '../views/sites/index.vue';
import CreateSite from '../views/sites/create.vue';
import ShowSite from '../views/sites/show.vue';
import SiteSettings from '../views/sites/settings.vue';

const routes = [
    { path: '/login', component: Login },
    { path: '/', component: Home },
    {
        path: '/permissions', component: Permissions, children: [
            { path: 'create', component: CreatePermissions }
        ]
    },
    {
        path: '/post-types', component: PostTypess, children: [
            { path: 'create', component: ManagePosts }
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
                path: ':task', component: ManageTask, meta: { child: true }, children: [
                    { path: 'edit', component: CreateTask, meta: { editing: true } },
                ]
            },
        ]
    },
    {
        path: '/sites', component: Sites, children: [
            { path: `create`, component: CreateSite }
        ]
    },
    {
        path: '/sites/:site', component: ShowSite, children: [
            { path: 'settings', component: SiteSettings },
            { path: 'create-page', component: CreatePost, meta: { forSite: true } },
            { path: ':post', component: CreatePost, meta: { forSite: true, editing: true } }
        ]
    },
    {
        path: '/:type', component: PostType, children: [
            { path: 'create', component: CreatePost },
            { path: ':post', component: ShowPost },
            { path: ':post/edit', component: CreatePost, meta: { editing: true } }
        ]
    }
]
export default routes;