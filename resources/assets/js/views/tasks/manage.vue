<template>
    <v-container grid-list-lg>
        <router-view></router-view>
        <header>
            <h1>{{task.name}}</h1>
        </header>
        <v-layout row wrap>
            <v-flex md3 v-for="child in task.children" :key="child.key">
                <v-card :to="`/tasks/${$route.params.task}/manage/${child.id}`">
                    <v-card-title>
                        <div>
                            <h2 class="title">
                                <v-icon>{{child.icon}}</v-icon> {{child.name}}
                            </h2>
                            <h3 class="subheading">                            
                                {{child.percent_finished}}% finished
                            </h3>
                        </div>
                    </v-card-title>
                    <v-card-text>
                        {{child.description}}
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <div class="fixed bottom right">
            <v-btn
                fab
                color="success"
                dark
                :to="`/tasks/${$route.params.task}/manage/edit`">
                <v-icon>create</v-icon>
            </v-btn>
            <v-btn
                fab
                color="pink"
                dark
                :to="`/tasks/${$route.params.task}/manage/add-task`">
                <v-icon>add</v-icon>
            </v-btn>
        </div>
    </v-container>
</template>

<script>
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      task: "",
      types: []
    };
  },
  watch: {
    $route() {
      this.init();
    }
  },
  computed: {
    $task() {
      return new Task(this, "task");
    },
    $types() {
      return new TaskType(this, "types");
    },
    $tasks() {
      return new Task(this, "tasks");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.showing = true;
      this.$task.find(this.$route.params.task);
    }
  }
};
</script>
