<template>
<v-container fluid grid-list-lg>
    <div style="position: absolute; bottom: 0px; width: 50vw; z-index: 999; left: 25vw;" class="elevation-6">
        <v-form @submit.prevent="assignUser">
            <v-card>
                <v-card-title>
                    <h2 class="title">
                        Assign Permissions
                    </h2>
                    <v-spacer></v-spacer>
                    <v-btn flat icon :to="`/users/${$route.params.user}`">
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
                    <v-btn type="submit" color="success">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </div>
    <!-- <div class="fixed bottom right">
        <v-btn fab color="accent" @click="adding = true;">
            <v-icon>add</v-icon>
        </v-btn>
    </div> -->
</v-container>
</template>

<script>
import User from "../../app/Models/User";
import PermissionMode from "../../app/Models/PermissionMode";
import Type from "../../app/Models/PermissionType";
import Permission from "../../app/Models/Permission";
export default {
  data() {
    return {
      adding: false,
      user: null,
      modes: [],
      assign: {
        mode: null,
        type: null,
        user: null
      },
      types: [],
      permissions: []
    };
  },
  computed: {
    $authUser() {
      return new User(this.$root, "user");
    },
    $modes() {
      return new PermissionMode(this, "modes");
    },
    $user() {
      return new User(this, "user");
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
      this.$user.find(this.$route.params.user);
      this.$types.get();
      this.$modes.get();
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
    removePermission(id) {
      this.$permissions.delete(id).then(() => {
        this.init();
      });
    }
  }
};
</script>
