<template>
  <v-container grid-list-lg>
    <router-view></router-view>
    <h1>
        All Tasks
    </h1>
    <v-layout row wrap>
      <v-flex md6 v-for="task in tasks" :key="task.key">
        <v-card ripple :to="`/tasks/${task.id}/manage`">
          <v-card-title :class="task.parent_id == 0 ? 'blue lighten-2' : 'grey lighten-2'">
            <div>
              <h2 class="title black--text">
                {{task.name}} ({{task.type_id ? task.type.name : 'No type yet...'}})
                <v-icon color="black">{{task.icon}}</v-icon>
              </h2>
              <h3 class="subheading mt-1 black--text" v-if="task.parent_id == 0">
                Previously a child task.
              </h3>
            </div>
          </v-card-title>
          <v-card-text>
            <p>
              {{task.description.length >= 40 ? task.description.substr(0, 40)+'...[Click to read more]' : task.description}}
            </p>
            <h2 v-if="task.type.name == 'Sprint'" class="title mb-2">{{task.percent_finished}}% Tasks Finished</h2>
              <div v-if="task.type.name == 'Sprint'" class="grey darken-1" style="padding: 0; width: 100%; height: 20px; border-radius: 50px;">
                <div class="primary" :style="`width:${task.percent_finished}%; height: 100%; border-radius: 50px;`"></div>
              </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
          <v-slide-x-transition>
            <v-btn
              v-if="!fam"
              color="primary"
              outline
              fab
              class="fixed bottom right"
              @click="fam = !fam">
              <v-icon>more_vert</v-icon>  
            </v-btn>
          </v-slide-x-transition>
          <v-slide-x-reverse-transition>
            <div class="fixed bottom right" v-if="fam">
                <v-btn v-if="$user.can('create', 'tasks')"
                    fab
                    color="accent"
                    dark
                    :to="`/tasks/create`">
                    <v-icon>add</v-icon>
                </v-btn>
                <v-btn
                    fab
                    color="primary"
                    outline
                    @click="fam = !fam">
                    <v-icon>chevron_right</v-icon>
                </v-btn>
            </div>
          </v-slide-x-reverse-transition>
  </v-container>
</template>

<script>
import Task from "../../app/models/Task";
import User from "../../app/models/User";
export default {
  data() {
    return {
      tasks: [],
      user: {},
      fam: false
    };
  },
  watch: {
    $route() {
      if (!this.$route.params.task) this.init();
    },
    previewing() {
      return this.preview();
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
