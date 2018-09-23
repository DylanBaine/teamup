// User Views
import Home from "../views/Home.vue";

// Group Views
import Groups from "../views/groups/index.vue";
import CreateGroup from "../views/groups/create.vue";
import ShowGroup from "../views/groups/show.vue";

// Task Views
import Tasks from "../views/tasks/index.vue";
import CreateTask from "../views/tasks/create.vue";
import ShowTask from "../views/tasks/show.vue";
import ManageTask from "../views/tasks/manage.vue";
//import EditTask from '../views/tasks/edit.vue';
import TaskSettings from "../views/tasks/settings.vue";

// Post Views
import PostType from "../views/posts/type.vue";
import ShowPost from "../views/posts/show.vue";
import CreatePost from "../views/posts/create.vue";
import ManagePosts from "../views/posts/manage.vue";
import PostTypes from "../views/posts/index.vue";

// Permission Views
import Permissions from "../views/permissions/index.vue";
import CreatePermissions from "../views/permissions/create.vue";

// Site Views ======== deep in backlog
import Sites from "../views/sites/index.vue";
import CreateSite from "../views/sites/create.vue";
import ShowSite from "../views/sites/show.vue";
import SiteSettings from "../views/sites/settings.vue";

// User Views
import Users from "../views/users/index.vue";
import ShowUser from "../views/users/show.vue";
import CreateUser from "../views/users/create.vue";
import ManageUser from "../views/users/manage.vue";

// File Views
import Files from "../views/files/index.vue";
import ShowFile from "../views/files/show.vue";
import CreateFile from "../views/files/create.vue";

// Client Views
import Client from "../views/clients/index.vue";
import CreateClient from "../views/clients/create.vue";
import ShowClient from "../views/clients/show.vue";

const routes = [
  { path: "/", component: Home },
  { path: "/posts", component: ManagePosts },
  {
    path: "/permissions",
    component: Permissions,
    children: [{ path: "create", component: CreatePermissions }]
  },
  {
    path: "/post-types",
    component: PostTypes,
    children: [{ path: "create", component: ManagePosts }]
  },
  {
    path: "/groups",
    component: Groups,
    children: [{ path: "create", component: CreateGroup }]
  },
  { path: "/groups/:group", component: ShowGroup },
  {
    path: "/tasks",
    component: Tasks,
    children: [
      { path: "create", component: CreateTask, meta: { controller: true } }
    ]
  },
  {
    path: "/tasks/:task/edit",
    component: CreateTask,
    meta: { editing: true }
  },
  {
    path: "/tasks/:task/add",
    component: CreateTask
  },
  {
    path: "/tasks/:task/manage",
    component: ManageTask
  },
  { path: "/tasks/:task/settings", component: TaskSettings },
  {
    path: "/users",
    component: Users,
    children: [{ path: "create", component: CreateUser }]
  },
  {
    path: "/users/:user",
    component: ShowUser,
    meta: { controller: true }
  },
  {
    path: "/file-type/:type",
    component: Files,
    meta: {
      controller: true,
      viewingType: true
    },
    children: [
      {
        path: "create",
        component: CreateFile
      }
    ]
  },
  {
    path: "/files",
    component: Files,
    meta: {
      controller: true
    },
    children: [
      {
        path: "/files/create",
        component: CreateFile
      },
      {
        path: ":file",
        component: ShowFile,
        meta: { controller: true }
      }
    ]
  },
  {
    path: "/clients",
    component: Client,
    children: [
      {
        path: "create",
        component: CreateClient
      }
    ]
  },
  {
    path: "/clients/:client",
    component: ShowClient
  },
  {
    path: "/:type",
    component: PostType,
    children: [
      { path: "create", component: CreatePost },
      { path: ":post", component: ShowPost },
      { path: ":post/edit", component: CreatePost, meta: { editing: true } }
    ]
  }
];
export default routes;
