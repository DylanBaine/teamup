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

// Site Views
import Sites from "../views/sites/index.vue";
import CreateSite from "../views/sites/create.vue";
import ShowSite from "../views/sites/show.vue";
import SiteSettings from "../views/sites/settings.vue";

// User Views
import Users from "../views/users/index.vue";
import ShowUser from "../views/users/show.vue";
import CreateUser from "../views/users/create.vue";

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
    children: [
      { path: "create", component: CreateGroup },
      { path: ":group", component: ShowGroup }
    ]
  },
  {
    path: "/tasks",
    component: Tasks,
    children: [
      { path: "create", component: CreateTask },
      { path: ":task", component: ShowTask }
    ]
  },
  {
    path: "/tasks/:task/manage/edit",
    component: CreateTask,
    meta: { editing: true }
  },
  {
    path: "/tasks/:task/manage",
    component: ManageTask,
    children: [
      { path: "add-task", component: CreateTask },

      {
        path: ":task",
        component: ManageTask,
        meta: { child: true },
        children: [
          { path: "edit", component: CreateTask, meta: { editing: true } }
        ]
      }
    ]
  },
  { path: "/tasks/:task/settings", component: TaskSettings },
  {
    path: "/users",
    component: Users,
    children: [
      { path: "create", component: CreateUser },
      { path: ":user", component: ShowUser }
    ]
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
