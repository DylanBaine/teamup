<template>
  <v-container fluid grid-list-lg>
    <router-view></router-view>
    <h1>
        All Tasks
    </h1>
    <v-layout row wrap v-if="tasks.length">
      <v-flex md6 v-for="task in tasks" :key="task.key">
        <v-card ripple :to="`/tasks/${task.id}/manage`">
          <v-card-title :class="task.parent_id == 0 ? 'blue lighten-2' : 'grey lighten-2'">
            <div>
              <h2 class="title black--text">
                {{task.name}} ({{task.type_id ? task.type.name : 'No type yet...'}})
                <v-icon color="black">{{task.icon}}</v-icon>
              </h2>
              <h3 class="subheading black--text">
                ID: {{task.id}}
              </h3>
              <h3 class="subheading mt-1 black--text" v-if="task.parent_id == 0">
                Previously a child task.
              </h3>
            </div>
          </v-card-title>
          <v-card-text>
            <h3 v-if="task.client">
              Client {{task.client.name}}
            </h3>
            <p v-html="task.description.shorten()"></p>
            <h2 v-if="task.type.name == 'Sprint'" class="title mb-2">{{task.percent_finished}}% Tasks Finished</h2>
              <div v-if="task.type.name == 'Sprint'" class="grey darken-1" style="padding: 0; width: 100%; height: 20px; border-radius: 50px;">
                <div class="primary" :style="`width:${task.percent_finished}%; height: 100%; border-radius: 50px;`"></div>
              </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout v-else>
      <h1 class="subheading">
        No tasks yet.
      </h1>
    </v-layout>
    <div class="fixed bottom right">
<!--         <v-btn v-if="$user.can('manage', 'tasks')"
            fab
            color="info"
            dark @click="settings = true">
            <v-icon>settings</v-icon>
        </v-btn> -->
        <v-btn v-if="$user.can('create', 'tasks')"
            fab
            color="accent"
            dark
            :to="`/tasks/create`">
            <v-icon>add</v-icon>
        </v-btn>
    </div>
      <v-dialog v-model="settings" width="500px">
        <v-card>
            <v-card-title class="grey lighten-2 black--text">
                <h2 class="title">
                    Global Task Types
                </h2>
                <v-spacer></v-spacer>
                <v-btn flat icon color="black" @click="settings = false">
                  <v-icon>close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text style="height: 60vh; overflow: auto;">
                <v-list>
                    <v-list-tile v-for="type in types" :key="type.key">
                        <v-list-tile-content>
                            <input type="text" class="padded ghost" v-model="type.name" @keyup.enter="$taskType.update(type.id, type)">
                        </v-list-tile-content>
                        <v-list-tile-action>
                            <v-btn flat icon @click="removeType(type.id)">
                                <v-icon color="grey">delete_forever</v-icon>
                            </v-btn>
                        </v-list-tile-action>
                    </v-list-tile>
                </v-list>
                <v-card-actions class="relative">
                    <v-text-field
                        label="New Task Type"
                        v-model="newType.name"
                    ></v-text-field>
                    <v-btn @click="addType" color="primary" fab absolute bottom right>
                        <v-icon>add</v-icon>    
                    </v-btn>                                
                </v-card-actions>
            </v-card-text>
        </v-card>
      </v-dialog>
  </v-container>
</template>

<script>
import Task from "../../app/models/Task";
import User from "../../app/models/User";
import TaskType from "../../app/models/TaskType";
export default {
  data() {
    return {
      tasks: [],
      user: {},
      fam: false,
      types: [],
      settings: false,
      newType: {
        name: ""
      }
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
    $types() {
      return new TaskType(this, "types");
    },
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
      if (this.$root.$user.can("create", "tasks")) this.$types.get();
    },
    addType() {
      this.$types.create(this.newType);
      this.newType = {
        name: ""
      };
    }
  }
};
</script>
