<template>
  <div class="container fluid">
      <router-view></router-view>
      <v-container fluid grid-list-lg v-if="task">
          <header>
              <h1>{{task.name}} ({{task.type.name}})</h1>
                <h3 class="subheading">
                  ID: {{task.id}}
                </h3>
                <h3 v-if="task.user" class="subheading">
                  User: <router-link :to="`/users/${task.user.id}`">{{task.user.name}}</router-link>
                </h3>
                <router-link to="/tasks">Tasks</router-link>
                <task-breadcrumb :icon-size="14" :item="task.parent" :original="task"></task-breadcrumb>
              <p v-html="task.description"></p>
          </header>
          <v-container fluid v-if="task.type.name == 'Sprint'" grid-list-lg>
            <v-layout row wrap>
                <draggable 
                  v-for="column in task.columns" :key="column.position"  
                  :items="column.children" :options="{group:'tasks', element: '.drag-me'}" 
                  :id="`${column.id}`" class="task-row flex md3 mt-2" @end="add" @start="start">
                <v-card>
                    <v-card-title>
                    <h2>{{column.value}}</h2>
                    </v-card-title>
                </v-card>
                <v-card v-for="child in column.children" :key="child.key" :to="`/tasks/${child.id}/manage`" :id="`${child.id}`" class="primary darken-1 mt-3 drag-me p-5 white--text">
                    <v-card-title>
                      <div>
                        <h2 class="title"> <v-icon color="white">{{child.icon}}</v-icon> {{child.name}}</h2>
                        <h3 class="subheader">{{child.type.name}}</h3>
                        <p v-if="child.user">{{child.user}}</p>
                      </div>
                    </v-card-title>
                    <v-card-text v-if="child.type.name !== 'Task'">
                    {{child.percent_finished}}% finished.
                    <div class="grey darken-1" style="padding: 0; width: 100%; height: 20px; border-radius: 50px;">
                    <div class="grey darken-2" :style="`width:${child.percent_finished}%; height: 100%; border-radius: 50px;`"></div>
                    </div>
                    </v-card-text>
                    <v-card-text v-else>
                      <p v-html="child.description"></p>
                    </v-card-text>
                </v-card>
                </draggable>
            </v-layout>
          </v-container>
          <v-layout row wrap v-else>
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
          <basic-task-report v-if="task.type.name == 'Task'" :report="task.report"></basic-task-report>
          <project-report v-else-if="task.type.name == 'Project'" :report="task.report"></project-report>
          <div class="fixed bottom right">
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
                  :to="`/tasks/${$route.params.task}/edit`">
                  <v-icon>create</v-icon>
              </v-btn>
              <v-btn
                  fab
                  color="info"
                  dark
                  @click="$refs.settings.init(task.id)">
                  <v-icon>settings</v-icon>
              </v-btn>
              <v-btn
                  v-if="task.type.name != 'Task'"
                  fab
                  color="accent"
                  dark
                  :to="`/tasks/${$route.params.task}/add`">
                  <v-icon>add</v-icon>
              </v-btn>
          </div>
          <task-settings ref="settings"></task-settings>
      </v-container>
  </div>
</template>

<script>
import Task from "../../app/models/Task";
import Report from "../../app/models/Report";

export default {
  data() {
    return {
      task: null,
      types: [],
      tasks: [],
      fam: false,
      loaded: false,
      report: null,
      subWeeks: 1
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
    this.init();
  },
  updated() {
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
      task.progressChange = true;
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
.progress {
  padding: 20px;
  border-radius: 15px;
}
</style>

