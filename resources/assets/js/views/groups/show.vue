<template>
<v-container fluid>
  <header>
      <h2 class="title">
          {{group.name}}
      </h2>
      <v-spacer></v-spacer>
  </header>
  <v-container>
    <v-layout grid-list-lg>
      <v-flex v-if="$root.$user.can('manage', 'groups')">
        <v-form @submit.prevent="add">
          <v-container>
            <v-layout row wrap>
              <v-flex md6>
                <v-autocomplete
                  label="User"
                  item-text="name"
                  item-value="id"
                  v-model="newUser"
                  :items="$root.users"
                ></v-autocomplete>
              </v-flex>
              <v-flex md3>
                <v-btn type="submit" color="primary">
                  Add
                </v-btn>
              </v-flex>
            </v-layout> 
          </v-container>
        </v-form>
      </v-flex>
      <v-flex>
        <v-list style="background: transparent; max-height: 300px; overflow: auto;">
          <v-list-tile class="grey darken-2 mb-1" v-for="user in group.users" :key="user.key">
            <v-list-tile-content>
              {{user.name}}
            </v-list-tile-content>
            <v-list-tile-action>
              <v-btn flat icon :to="`/users/${user.id}`">
                <v-icon>remove_red_eye</v-icon>
              </v-btn>
            </v-list-tile-action>
            <v-list-tile-action>
              <v-btn icon flat @click="removeUser(user.id)" color="error">
                <v-icon>delete_forever</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
        </v-list>
      </v-flex>
    </v-layout>
    <header>
      <h2 class="title mb-2">
        Tasks
      </h2>
    </header>
    <v-layout row wrap>
      <v-flex md6 v-for="task in group.tasks" :key="task.id">
        <v-card :to="`/tasks/${task.id}/manage`">
          <v-card-title class="grey lighten-2 black--text">
            <h2 class="title">
              {{task.name}} ({{task.type.name}})
            </h2>
          </v-card-title>
          <v-card-text v-if="task.parent">
            <task-breadcrumbs :original="task" :item="task.parent"></task-breadcrumbs>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</v-container>
</template>

<script>
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      group: "",
      showing: false,
      newUser: null
    };
  },
  computed: {
    $group() {
      return new Group(this, "group");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.newUser = null;
      this.$group.find(this.$route.params.group).then(() => {
        this.showing = true;
      });
    },
    add() {
      this.$group.addUser(this.newUser).then(() => {
        this.init();
      });
    },
    removeUser(userId) {
      this.$group.removeUser(userId).then(() => {
        this.init();
      });
    }
  }
};
</script>
