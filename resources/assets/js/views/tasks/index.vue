<template>
  <v-container grid-list-lg>
    <router-view></router-view>
    <h1>
        All Tasks
    </h1>
    <v-layout row wrap>
      <v-flex md6 v-for="task in tasks.filter(task=>{return task.parent_id == null})" :key="task.key">
        <v-card ripple :to="`/tasks/${task.id}`">
          <v-card-title class="grey lighten-2">
            <h2 class="title black--text">
              {{task.name}} ({{task.type.name}})
              <v-icon color="black">{{task.icon}}</v-icon>
            </h2>
          </v-card-title>
        </v-card>
      </v-flex>
    </v-layout>
    <v-btn
      v-if="$user.can('create', 'tasks')"
      fab
      bottom
      right
      color="pink"
      dark
      fixed
      :to="`/tasks/create`">
      <v-icon>add</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
import Task from "../../app/models/Task";
import User from "../../app/models/User";
export default {
  data() {
    return {
      tasks: [],
      user: {}
    };
  },
  watch: {
    $route() {
      if (!this.$route.params.task) this.init();
    }
  },
  computed: {
    $tasks() {
      return new Task(this, "tasks");
    },
    $user() {
      return new User(this.$root, "user");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$tasks.get();
    }
  }
};
</script>
