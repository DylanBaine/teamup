<template>
    <v-dialog
        v-model="showing" persistent
        transition="dialog-transition">
        <v-card>
            <v-toolbar color="primary">
                <div>
                    <h2 class="title">
                        {{user.name}}
                    </h2>
                    <h3 class="subheading">
                        <v-icon class="mr-2" small>email</v-icon><a class="white--text" :href="'mailto:'+user.email">{{user.email}}</a>
                    </h3>
                </div>
                <v-spacer></v-spacer>
                <v-tabs centered color="primary" slot="extension" v-model="tab">
                    <v-tab v-if="user.tasks.length" href="#tasks">
                        Tasks
                    </v-tab>
                    <v-tab href="#permissions">
                        Permissions
                    </v-tab>
                </v-tabs>
                <v-btn flat color="white" icon to="/users">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-tabs-items v-model="tab" style="height: 70vh; overflow: auto">
                <v-tab-item v-if="user.tasks.length" id="tasks">
                    <v-card flat v-if="user.tasks.length">
                      <v-card-title>
                            <h3>Tasks</h3>
                        </v-card-title>
                        <v-card-text style="max-height: 585px; overflow: auto;">
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex md4 v-for="task in user.tasks" :key="task.id" style="cursor: pointer" @click="$refs.taskPreview.init(task.id)">
                                        <v-card class="grey black--text lighten-2">
                                            <v-card-text>
                                                <h4>
                                                    {{task.name}}
                                                </h4>
                                                <h5 v-if="task.column">
                                                    <task-breadcrumb icon-color="black" :icon-size="13" :item="task"></task-breadcrumb> {{task.type.name}} <v-icon color="black" :size="13">arrow_forward</v-icon> {{task.column.value}}
                                                </h5>
                                                <h5 v-else>
                                                    {{task.type.name}}
                                                </h5>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item id="permissions">
                    <v-card flat>
                        <v-card-title>
                            <h3>Permissions</h3>
                            <v-tooltip right>
                                <v-btn slot="activator" color="accent" icon v-if="$root.$user.can('assign', 'permissions')" @click="addingPermissions = true">
                                    <v-icon>add</v-icon>
                                </v-btn>
                                <span>Add a new permission</span>
                            </v-tooltip>
                        </v-card-title>
                        <v-card-text style="max-height: 585px; overflow: auto;">
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Create
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                                <v-list-tile v-for="permission in $user.permissions('create')" :key="permission.id">
                                                    <v-list-tile-content>
                                                        {{permission.type.name}}
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                            <v-icon size="20px">delete_forever</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>                        
                                    </v-flex>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Read
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                            <v-list-tile v-for="permission in $user.permissions('read')" :key="permission.id">
                                                    <v-list-tile-content>
                                                        {{permission.type.name}}
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                            <v-icon size="20px">delete_forever</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>                        
                                    </v-flex>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Update
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                                <v-list-tile v-for="permission in $user.permissions('update')" :key="permission.id">
                                                    <v-list-tile-content>
                                                        {{permission.type.name}}
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                            <v-icon size="20px">delete_forever</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>                        
                                    </v-flex>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Delete
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                                <v-list-tile v-for="permission in $user.permissions('delete')" :key="permission.id">
                                                    <v-list-tile-content>
                                                        {{permission.type.name}}
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                            <v-icon size="20px">delete_forever</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>                        
                                    </v-flex>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Manage
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                            <v-list-tile v-for="permission in $user.permissions('manage')" :key="permission.id">
                                                <v-list-tile-content>
                                                    {{permission.type.name}}
                                                </v-list-tile-content>
                                                <v-list-tile-action>
                                                    <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                        <v-icon size="20px">delete_forever</v-icon>
                                                    </v-btn>
                                                </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>
                                    </v-flex>
                                    <v-flex lg2 md3 sm4 sx6>
                                        <h4>
                                            Assign
                                        </h4>
                                        <v-divider></v-divider>
                                        <v-list>
                                                <v-list-tile v-for="permission in $user.permissions('assign')" :key="permission.id">
                                                    <v-list-tile-content>
                                                        {{permission.type.name}}
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-btn v-if="$root.$user.can('delete', 'permissions')" flat icon color="error" @click="deletePermission(permission.id)">
                                                            <v-icon size="20px">delete_forever</v-icon>
                                                        </v-btn>
                                                    </v-list-tile-action>
                                            </v-list-tile>
                                        </v-list>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
            <v-slide-x-reverse-transition>
                <div style="position: absolute; top: 20px; width: 50vw; z-index: 999; left: 25vw;" class="elevation-6" v-if="addingPermissions">
                    <v-form @submit.prevent="assignUser">
                        <v-card>
                            <v-card-title>
                                <h2 class="title">
                                    Assign Permissions
                                </h2>
                                <v-spacer></v-spacer>
                                <v-btn flat icon @click="addingPermissions = false">
                                    <v-icon>close</v-icon>
                                </v-btn>
                            </v-card-title>
                            <v-card-text>
                                <v-container fluid grid-list-lg>
                                    <v-layout row wrap>
                                        <v-flex md6>
                                            <v-select
                                                :items="modes"
                                                v-model="assign.mode"
                                                item-text="name"
                                                item-value="id"
                                                label="Mode"
                                            ></v-select>
                                        </v-flex>
                                        <v-flex md6>
                                            <v-select
                                                :items="types"
                                                v-model="assign.type"
                                                item-text="name"
                                                item-value="id"
                                                label="Permissable"
                                            ></v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn type="submit" color="primary">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </div>                    
            </v-slide-x-reverse-transition>
        </v-card>
        <task-preview ref="taskPreview"></task-preview>
    </v-dialog>
</template>

<script>
import User from "../../app/models/User.js";
import PermissionMode from "../../app/Models/PermissionMode";
import Type from "../../app/Models/PermissionType";
import Permission from "../../app/Models/Permission";
export default {
  data() {
    return {
      tab: "tasks",
      addingPermissions: false,
      user: {
        name: null,
        tasks: [],
        permissions: []
      },
      showing: false,
      types: [],
      modes: [],
      assign: {
        mode: null,
        type: null,
        user: null
      }
    };
  },
  computed: {
    $permissions() {
      return new Permission(this, "permissions");
    },
    $modes() {
      return new PermissionMode(this, "modes");
    },
    $types() {
      return new Type(this, "types");
    },
    $authUser() {
      return new User(this.$root, "user");
    },
    $user() {
      return new User(this, "user");
    },
    createPermissions() {
      return this.user.permissions.filter(permission => {
        return permission.mode.name == "create";
      });
    },
    readPermissions() {
      return this.user.permissions.filter(permission => {
        return permission.mode.name == "read";
      });
    },
    updatePermissions() {
      return this.user.permissions.filter(permission => {
        return permission.mode.name == "update";
      });
    },
    deletePermissions() {
      return this.user.permissions.filter(permission => {
        return permission.mode.name == "delete";
      });
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$root.getPage().then(() => {
        var p = this.$root.page;
        this.user = p.user;
        this.modes = p.modes;
        this.types = p.types;
        this.showing = true;
      });
    },
    assignUser() {
      this.assign.user = this.user.id;
      this.$permissions.create(this.assign).then(() => {
        this.init();
        this.assign = {
          type: null,
          mode: null,
          user: null
        };
      });
    },
    deletePermission(id) {
      this.$permissions.delete(id, "init");
    }
  }
};
</script>