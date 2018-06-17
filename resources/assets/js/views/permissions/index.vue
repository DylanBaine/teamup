<template>
    <v-container grid-list-lg>
        <h1 class="mb-4">
            Permissions
        </h1>
        <v-layout row wrap fill-height align-top>
            <v-flex md5 v-if="$user.can('assign', 'permissions')">
                <v-form @submit.prevent="assignUser">
                    <v-card>
                        <v-card-title>
                            <h2 class="title">
                                Assign Permissions
                            </h2>
                        </v-card-title>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex md12>
                                    <v-select
                                        autocomplete
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        v-model="assign.user"
                                        label="User"
                                        :search-input.sync="search"
                                    ></v-select>
                                </v-flex>
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
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn type="submit" color="success">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-flex>
            <v-flex md7 v-if="$user.can('manage', 'permissions')">
                <v-card>
                    <v-card-title>
                        <div>
                            <h2 class="title">
                                Manage Permissions
                            </h2>
                            <v-select
                                clearable
                                autocomplete
                                :items="users"
                                item-text="name"
                                item-value="id"
                                v-model="permissionSearch"
                                label="User"
                                :search-input.sync="search"
                            ></v-select>
                        </div>
                    </v-card-title>
                    <v-card-text style="max-height: 40vh; overflow: auto;">
                        <v-data-table
                            hide-actions
                            :items="permissions"
                            disable-initial-sort
                            :headers="[
                                { text: 'User', value: 'user.name' },
                                { text: 'Mode', value: 'mode.name' },
                                { text: 'Type', value: 'type.name' },
                                { text: ' ', value: 'action' },
                            ]">
                                <template slot="items" slot-scope="props">
                                    <td>{{ props.item.user.name }}</td>
                                    <td>{{ props.item.mode.name }}</td>
                                    <td>{{ props.item.type.name }}</td>
                                    <td>
                                        <v-btn v-if="$user.can('delete', 'tasks')" @click="removePermission(props.item.id)" flat icon color="grey">
                                            <v-icon>delete_forever</v-icon>
                                        </v-btn>
                                    </td>
                                </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex md6>
                <v-card>
                    <v-card-title class="grey lighten-2 black--text">
                        <h2 class="title">
                            Permission Modes
                        </h2>
                    </v-card-title>
                    <v-card-text style="max-height: 40vh; overflow: auto;">
                        <v-list v-if="modes.length">
                            <v-list-tile v-for="mode in modes" :key="mode.key">
                                <v-list-tile-content>
                                    {{mode.name}}
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-btn color="grey" flat icon @click="removeMode(mode.id)">
                                        <v-icon>delete_forever</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-card-text>
                    <v-card-actions v-if="$user.can('create', 'permission-modes')">
                        <v-form @submit.prevent="addMode()" style="width: 100%;">
                            <v-text-field
                                label="New Permission Mode"
                                v-model="newMode"
                            ></v-text-field>
                            <v-btn type="submit" fab color="success" absolute bottom right>
                                <v-icon dark>add</v-icon>
                            </v-btn>
                        </v-form>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex md6>
                <v-card>
                    <v-card-title class="grey lighten-2 black--text">
                        <h2 class="title">
                            Permissables
                        </h2>
                    </v-card-title>
                    <v-card-text style="max-height: 40vh; overflow: auto;">
                        <v-list v-if="types.length">
                            <v-list-tile v-for="type in types" :key="type.key">
                                <v-list-tile-content>
                                    {{type.name}}
                                </v-list-tile-content>
                                <v-list-tile-action>
                                    <v-btn color="grey" flat icon @click="removeType(type.id)">
                                        <v-icon>delete_forever</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-card-text>
                    <v-card-actions v-if="$user.can('create', 'permission-types')">
                        <v-form @submit.prevent="addType()" style="width: 100%;">
                            <v-dialog v-model="selectingIcon" :width="500">
                                <icon-selector v-model="newType.icon"></icon-selector>
                            </v-dialog>
                            <v-layout row wrap>
                                <v-flex md5>
                                    <v-text-field
                                        label="New Permissable"
                                        v-model="newType.name"
                                    ></v-text-field>                                    
                                </v-flex>
                                <v-flex md3 class="d-flex align-center">
                                    <v-btn outline color="grey" @click="selectingIcon = true">
                                        Icon
                                    </v-btn>
                                </v-flex>
                                <v-flex md4>
                                    <v-select
                                        :items="[
                                            'Post', 'Task', 'Group', 'File'
                                        ]"
                                        v-model="newType.model"
                                        label="Model"
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                            <v-btn type="submit" fab color="success" absolute bottom right>
                                <v-icon dark>add</v-icon>
                            </v-btn>
                        </v-form>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import PermissionMode from "../../app/Models/PermissionMode";
import Type from "../../app/Models/PermissionType";
import Permission from "../../app/Models/Permission";
import User from "../../app/models/User";
export default {
  data() {
    return {
      selectingIcon: false,
      permissionSearch: null,
      searchPermissions: null,
      tableItems: [],
      permissions: [],
      users: [],
      modes: [],
      newMode: "",
      types: [],
      newType: {
        name: null,
        model: null,
        icon: null
      },
      assign: {
        type: null,
        mode: null,
        user: null
      },
      search: null
    };
  },
  watch: {
    search() {
      if (this.search && this.search.length > 3) {
        this.$users.where("name", this.search);
      }
    },
    permissionSearch() {
      if (this.permissionSearch !== null) {
        this.$permissions.where("user_id", this.permissionSearch);
      } else {
        this.$permissions.get();
      }
    }
  },
  computed: {
    $users() {
      return new User(this, "users");
    },
    $modes() {
      return new PermissionMode(this, "modes");
    },
    $user() {
      return new User(this.$root, "user");
    },
    $types() {
      return new Type(this, "types");
    },
    $permissions() {
      return new Permission(this, "permissions");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$modes.get().collection;
      this.$types.get().collection;
      this.$permissions.get().then(() => {
        this.formattedPermissions();
      }).collection;
    },
    addMode() {
      this.$modes.create({ name: this.newMode }).then(() => {
        this.newMode = "";
      });
    },
    removeMode(mode) {
      this.$modes.delete(mode);
    },
    addType() {
      this.$types.create(this.newType).then(() => {
        this.newType = {
          name: null,
          model: null
        };
      });
    },
    removeType(type) {
      this.$types.delete(type);
    },
    assignUser() {
      this.$permissions.create(this.assign).then(() => {
        this.assign = {
          type: null,
          mode: null,
          user: null
        };
      });
    },
    formattedPermissions() {
      var array = [];
      this.permissions.forEach(permission => {
        let obj = {
          id: permission.id,
          mode: permission.mode.name,
          type: permission.type.name,
          user: permission.user.name
        };
        array.push(obj);
      });
      this.tableItems = array;
    },
    removePermission(id) {
      this.$permissions.delete(id);
    }
  }
};
</script>