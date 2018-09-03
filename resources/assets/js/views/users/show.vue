<template>
    <v-dialog
        v-model="showing" persistent
        transition="dialog-transition">
        <v-card>
            <v-toolbar color="primary">
                <v-btn flat color="white" icon to="/users">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">
                    {{user.name}}
                </h2>
                <v-spacer></v-spacer>
                <v-btn flat color="white" v-if="$authUser.can('assign', 'permissions')" @click="addingPermissions = true">Add Permissions</v-btn>
            </v-toolbar>
            <v-card-text style="height: 70vh; overflow: auto">
                <v-card v-if="user.tasks.length">
                    <v-card-title>
                        <h3>Tasks</h3>
                    </v-card-title>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex md4 v-for="task in user.tasks" :key="task.id">
                                <v-card class="grey black--text lighten-2" :to="'/tasks/'+task.id">
                                    <v-card-text>
                                        <h4>
                                            {{task.name}}
                                        </h4>
                                        <h5 class="subheading">
                                            {{task.column.value}}
                                        </h5>
                                    </v-card-text>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
                <v-card>
                    <v-card-title>
                        <h3>Permissions</h3>
                    </v-card-title>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex md2>
                                <h4>
                                    Create
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('create')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>                        
                            </v-flex>
                            <v-flex md2>
                                <h4>
                                    Read
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('read')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>                        
                            </v-flex>
                            <v-flex md2>
                                <h4>
                                    Update
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('update')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>                        
                            </v-flex>
                            <v-flex md2>
                                <h4>
                                    Delete
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('delete')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>                        
                            </v-flex>
                            <v-flex md2>
                                <h4>
                                    Manage
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('manage')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                            </v-flex>
                            <v-flex md2>
                                <h4>
                                    Assign
                                </h4>
                                <v-divider></v-divider>
                                <v-list>
                                    <v-list-tile v-for="permission in $user.permissions('assign')" :key="permission.id">
                                        <v-list-tile-content>
                                            {{permission.type.name}}
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </v-list>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
                <v-slide-x-reverse-transition>
                    <div style="position: absolute; bottom: 0px; width: 50vw; z-index: 999; left: 25vw;" class="elevation-6" v-if="addingPermissions">
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
                                    <v-container grid-list-lg>
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
                                    <v-btn type="submit" color="success">Save</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-form>
                    </div>                    
                </v-slide-x-reverse-transition>
            </v-card-text>
        </v-card>
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
      this.showing = true;
      this.$user.find(this.$route.params.user);
      this.$modes.get();
      this.$types.get();
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
    }
  }
};
</script>