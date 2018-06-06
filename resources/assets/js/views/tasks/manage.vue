<template>
  <div>
      <router-view></router-view>
      <v-container grid-list-lg>
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
                <v-btn
                    fab
                    color="warning"
                    dark
                    @click="remove($route.params.task)">
                    <v-icon>delete_forever</v-icon>
                </v-btn>
                <v-btn
                    fab
                    color="success"
                    dark
                    :to="`/tasks/${$route.params.task}/manage/edit`">
                    <v-icon>create</v-icon>
                </v-btn>
                <v-btn
                    fab
                    color="info"
                    dark
                    :to="`/tasks/${$route.params.task}/manage/settings`">
                    <v-icon>settings</v-icon>
                </v-btn>
                <v-btn
                    fab
                    color="accent"
                    dark
                    :to="`/tasks/${$route.params.task}/manage/add-task`">
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
  </div>
</template>

<script>
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      task: "",
      types: [],
      tasks: [],
      fam: false
    };
  },
  watch: {
    $route() {
      if (!this.$route.params.child && !this.$route.meta.editing) this.init();
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
      this.$tasks.get().then(res => {
        if (!this.task.name) {
          this.$router.push("/tasks");
        }
      });
    },
    remove(id) {
      this.$task.delete(id).then(res => {
        this.init();
      });
    }
  }
};
</script>
