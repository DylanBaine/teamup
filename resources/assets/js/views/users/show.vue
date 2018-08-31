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
            </v-card-text>
        </v-card>        
    </v-dialog>
</template>

<script>
import User from "../../app/models/User.js";
export default {
  data() {
    return {
      user: null,
      showing: false
    };
  },
  computed: {
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
    }
  }
};
</script>