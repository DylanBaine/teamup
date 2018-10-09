<template>
  <div class="container fluid">
      <router-view></router-view>
      <v-container class="mb-4" fluid grid-list-lg v-if="task">
          <header>
            <v-layout row wrap>
              <v-flex md3>
                <h1>{{task.name}} ({{task.type.name}})</h1>
                  <h3 class="subheading">
                    ID: {{task.id}}
                  </h3>
                  <ul>
                    <li v-if="task.start_date_string">
                      Start: {{task.start_date_string}}
                    </li>
                    <li v-if="task.end_date_string">
                      End: {{task.end_date_string}}
                    </li>
                  </ul>
                  <h3 v-if="task.user" class="subheading">
                    {{task.type.name == 'Task' ? 'Assigned To' : 'Manager'}}: <router-link :to="`/users/${task.user.id}`">{{task.user.name}}</router-link>
                  </h3>
                  <h3 v-if="task.group" class="subheading">
                    Group: <router-link :to="`/groups/${task.group.id}`">{{task.group.name}}</router-link>
                  </h3>
                  <h3 v-if="task.client" class="subheading">
                    Client: <router-link :to="`/clients/${task.client.id}`">{{task.client.name}}</router-link>
                  </h3>
              </v-flex>
              <v-flex md6 style="position: relative">
                <h2 class="title">
                  Description:
                  <v-btn v-if="task.description.length > 300" small @click="fullDescription = true" flat>
                    <v-icon>fullscreen</v-icon> Fullscreen
                  </v-btn>
                </h2>
                <p class="mt-2" style="max-height: 100px; overflow: auto;" v-html="task.description"></p>
              </v-flex>
              <v-flex>
                <header>
                  <h2 class="title">
                    Files
                  </h2>
                </header>
              </v-flex>
            </v-layout>
            <router-link to="/tasks">Tasks</router-link> <task-breadcrumb :icon-size="14" :item="task.parent" :original="task"></task-breadcrumb>
          </header>
          <v-tooltip :disabled="!shouldShowScrollTip()" top color="info" v-if="task.type.name == 'Sprint'" >
            <div ref="columnScroller" slot="activator" class="padded" style="width: 100%; min-height: 500px; overflow: auto; overflow-y: hidden;" @scroll="scroll">
              <div ref="columnContainer" :style="rowsContainerStyle">
                <v-layout row>
                    <draggable 
                      v-for="column in task.columns" :key="column.position"  
                      :items="column.children" :options="{group:'tasks', element: '.drag-me'}" 
                      :id="`${column.id}`" style="width: 300px; margin-right: 20px;" class="mb-2 mt-2" @end="add" @start="start">
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
              </div>
            </div>
            <span class="padded">
              [SHIFT + Scroll] To scroll left and right.
            </span>
          </v-tooltip>
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
                    <h3 v-if="task.client" class="mb-2">
                      Client: {{task.client.name}}
                    </h3>
                  <p v-html="task.description.length >= 40 ? task.description.substr(0, 40)+'...[Click to read more]' : task.description">
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
          <v-dialog v-model="fullDescription" fullscreen persistent>
            <v-card>
              <v-card-title>
                <h2 class="title">Description:</h2>
                <v-spacer></v-spacer>
                <v-btn @click="fullDescription = false" flat icon>
                  <v-icon>close</v-icon>
                </v-btn>
              </v-card-title>
              <v-card-text v-html="task.description"></v-card-text>
            </v-card>
          </v-dialog>
          <div v-if="!$root.$user.can('manage', 'tasks')" class="fixed bottom right">
              <v-btn
                  fab
                  color="warning"
                  dark
                  v-if="$root.$user.can('delete', 'tasks')"
                  @click="remove($route.params.task)">
                  <v-icon>delete_forever</v-icon>
              </v-btn>
              <v-btn
                  fab
                  color="success"
                  dark
                  v-if="$root.$user.can('update', 'tasks')"
                  :to="`/tasks/${$route.params.task}/edit`">
                  <v-icon>create</v-icon>
              </v-btn>
              <v-btn
                  v-if="$root.$user.can('create', 'Notifications')"
                  fab
                  color="info"
                  dark
                  @click="$refs.settings.init(task.id)">
                  <v-icon>settings</v-icon>
              </v-btn>
              <v-btn
                  fab
                  color="accent"
                  dark
                  v-if="task.type.name != 'Task' && $root.$user.can('create', 'tasks')"
                  :to="`/tasks/${$route.params.task}/add`">
                  <v-icon>add</v-icon>
              </v-btn>
          </div>
          <div v-else class="fixed bottom right">
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
                  fab
                  color="accent"
                  dark
                  v-if="task.type.name != 'Task'"
                  :to="`/tasks/${$route.params.task}/add`">
                  <v-icon>add</v-icon>
              </v-btn>            
          </div>
      </v-container>
      <task-settings ref="settings"></task-settings>
  </div>
</template>

<script>
import Task from "../../app/models/Task";
import Report from "../../app/models/Report";

export default {
  data() {
    return {
      fullDescription: false,
      task: null,
      types: [],
      tasks: [],
      fam: false,
      loaded: false,
      report: null,
      subWeeks: 1,
      modal: false
    };
  },
  watch: {
    modal() {
      if (!this.modal) this.init();
    },
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
    rowsContainerStyle() {
      return `width: ${this.task.columns.length * 320}px; position: relative`;
    },
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
    shouldShowScrollTip() {
      if (this.$refs.columnContainer && this.$refs.columnScroller) {
        return (
          this.$refs.columnContainer.offsetWidth >
          this.$refs.columnScroller.offsetWidth
        );
      }
      return false;
    },
    scroll(e) {
      console.log(e);
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

