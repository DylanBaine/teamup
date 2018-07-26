<template>
  <div class="container">
      <router-view></router-view>
      <v-container grid-list-lg>
          <header>
              <h1>{{task.name}}</h1>
              <h4 v-if="task.parent_id">
                Parent: <router-link :to="`/tasks/${task.parent_id}/manage`">{{task.parent.name}}</router-link>
              </h4>
              <h4 v-else>
                Parent: <router-link to="/tasks">Tasks</router-link>
              </h4>
              <p>{{task.description}}</p>
          </header>
          <v-container v-if="task.type.name == 'Sprint'" grid-list-lg>
            <v-layout row wrap>
              <draggable v-for="column in task.columns" :key="column.position"  :items="column.children" :options="{group:'tasks', element: '.drag-me'}" :id="`${column.id}`" class="task-row flex md3 mt-2" @end="add" @start="start">
                <v-card>
                  <v-card-title>
                    <h2>{{column.value}}</h2>
                  </v-card-title>
                </v-card>
                <v-card v-for="child in column.children" :key="child.key" :to="`/tasks/${child.id}/manage`" :id="`${child.id}`" class="primary darken-1 mt-3 drag-me p-5 white--text">
                  <v-card-title>
                    <h2 class="title"> <v-icon color="white">{{child.icon}}</v-icon> {{child.name}}</h2>
                    <h3 class="subheader">{{child.type.name}}</h3>
                  </v-card-title>
                  <v-card-text v-if="child.type.name !== 'Task'">
                    {{child.percent_finished}}% finished.
                  <div class="grey darken-1" style="padding: 0; width: 100%; height: 20px; border-radius: 50px;">
                    <div class="grey darken-2" :style="`width:${child.percent_finished}%; height: 100%; border-radius: 50px;`"></div>
                  </div>
                  </v-card-text>
                  <v-card-text v-else>
                    {{child.description}}
                  </v-card-text>
                </v-card>
              </draggable>
            </v-layout>
          </v-container>
          <v-container v-else grid-list-lg>
            <v-layout row wrap>
              <v-flex md6 v-for="task in task.children" :key="task.key">
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
                    :to="`/tasks/${$route.params.task}/settings`">
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
      this.init();
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
    console.log("mounted");
    this.init();
  },
  updated() {
    console.log(this.$key);
    this.$mount();
    this.columnItems();
  },
  methods: {
    init() {
      this.loaded = true;
      this.$task.find(this.$route.params.task);
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

