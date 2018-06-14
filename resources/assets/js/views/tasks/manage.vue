<template>
  <div class="container">
      <router-view></router-view>
      <v-container grid-list-lg>
          <header>
              <h1>{{task.name}}</h1>
              <p>{{task.description}}</p>
          </header>
          <v-container grid-list-lg>
            <v-layout row wrap>
              <draggable v-for="column in task.columns" :key="column.position"  :items="column.children" :options="{group:'tasks', element: '.drag-me'}" :id="`${column.id}`" class="task-row flex md3 mt-2" @end="add" @start="start">
                <v-card>
                  <v-card-title>
                    <h2>{{column.value}}</h2>
                  </v-card-title>
                </v-card>
                <v-card v-for="child in column.children" :key="child.key" :to="`/tasks/${task.id}/manage/${child.id}`" :id="`${child.id}`" class="primary darken-1 mt-3 drag-me p-5 white--text">
                  <v-card-title>
                    <h2 class="title"> <v-icon color="white">{{child.icon}}</v-icon> {{child.name}}</h2>
                  </v-card-title>
                  <v-card-text>
                    {{child.description}}
                  </v-card-text>
                </v-card>
              </draggable>
            </v-layout>
          </v-container>
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
      fam: false,
      loaded: false
    };
  },
  watch: {
    $route() {
      this.fam = false;
      if (!this.$route.params.child && !this.$route.meta.editing) this.init();
    },
    task() {
      if (!this.dragging) {
        this.columnItems();
      }
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
      this.loaded = true;
      this.$task.find(this.$route.params.task);
      this.$tasks.get();
    },
    remove(id) {
      this.$task.delete(id).then(res => {
        this.init();
      });
    },
    columnItems() {
      console.log("arganizing");
      this.task.columns.forEach(column => {
        column.children = this.task.children.filter(child => {
          return child.column_id == column.id;
        });
      });
    },
    add(e) {
      var newParent = e.to.id;
      var target = e.item.id;
      var task = this.task.children.filter(task => {
        return task.id == target;
      })[0];
      task.column_id = newParent;
      this.$task.update(task.id, task, "quick");
    },
    start(e) {}
  }
};
</script>

<style>
.sortable-ghost {
  opacity: 0;
}
.task-row {
  min-height: 60vh;
}
</style>

