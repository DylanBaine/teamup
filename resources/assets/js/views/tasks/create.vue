<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
          <v-toolbar dark color="primary">
            <h2 class="title" v-if="parent">
              Creating a child of {{parent.name}}
            </h2>
            <v-spacer></v-spacer>
              <v-btn icon :to="$route.params.task ? `/tasks/${$route.params.task}/manage` : '/tasks/'">
                  <v-icon>close</v-icon>
              </v-btn>
          </v-toolbar>
          <v-form @submit.prevent="post()">
            <v-container fluid grid-list-xl>
              <v-stepper non-linear v-model="step">
                <v-stepper-header>
                  <v-stepper-step editable :rules="metaRules" @input="step = 1" step="1">Name and assignment</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step editable :complete="step > 2" step="2">Details</v-stepper-step>
                  <v-divider v-if="setType != 'Team'"></v-divider>
                  <v-stepper-step editable v-if="setType != 'Team'" :rules="dateRules" step="3">Timespan</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step editable :complete="step > 3" step="4">Confirm And Save</v-stepper-step>
                </v-stepper-header>
                <v-stepper-items>
                  <v-stepper-content step="1">
                    <div class="padded">
                      <v-layout row wrap justify-center>
                        <v-flex md4>
                          <v-select
                            v-model="task.type_id"
                            label="Type"
                            :items="types"
                            item-avatar="icon"
                            item-text="name"
                            item-value="id">
                          </v-select>
                        </v-flex>
                        <v-flex md4 v-if="setType != 'Team'">
                          <v-autocomplete
                            :label="taskUserLabel"
                            :items="users"
                            item-value="id"
                            item-text="name"
                            v-model="task.user_id"
                            hint="Start typing to find a user.">
                          </v-autocomplete>
                        </v-flex>
                        <v-flex md4 v-else>
                          <v-autocomplete
                            label="Group"
                            :items="groups"
                            item-value="id"
                            item-text="name"
                            v-model="task.user_id"
                            hint="Start typing to find a group.">
                          </v-autocomplete>
                        </v-flex>
                      </v-layout>
                      <v-layout row wrap justify-center>
                        <v-flex md8>
                          <v-text-field
                            label="Name"
                            v-model="task.name"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content step="2">
                    <div class="padded">
                      <div>
                        <v-layout row wrap align-center>
                          <v-flex md6>
                            <icon-selector
                              label="Select an icon"
                              v-model="task.icon"
                            ></icon-selector>
                          </v-flex>
                          <v-flex md6>
                            <v-textarea
                              label="Description"
                              v-model="task.description"
                            ></v-textarea>
                          </v-flex>
                        </v-layout>
                      </div>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content v-if="setType != 'Team'" step="3">
                    <div class="padded">
                      <div>
                        <v-layout row wrap justify-center>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div>
                              <h3>Date:</h3>
                              <v-date-picker v-model="date" multiple color="primary white--text"></v-date-picker>
                            </div>
                          </v-flex>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div v-if="date.length">
                              <span>Start: {{task.start_date}} End: {{task.end_date}}</span>
                            </div>
                          </v-flex>
                        </v-layout>     
                      </div>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content class="padded" step="4">
                      <v-card style="margin: auto;">
                        <v-card-text>
                          <v-layout row wrap>
                            <v-flex md3 class="padded">
                              <h4>Name: {{task.name}}</h4>
                            </v-flex>
                            <v-flex md3 class="padded">
                              <h4>Type: {{setType}}</h4>
                            </v-flex>
                            <v-flex md3 class="padded">
                              <h4>Assigned To: {{setAssignedTo}}</h4>
                            </v-flex>
                          </v-layout>
                          <v-layout v-if="setType != 'Team'" row wrap class="mt-4">
                            <v-flex class="padded" md3>
                              <h4>Start: {{task.start_date}}</h4>
                            </v-flex>
                            <v-flex class="padded" md3>
                              <h4>End: {{task.start_date}}</h4>
                            </v-flex>
                          </v-layout>
                        </v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="primary" large block @click="post">Save</v-btn>
                          <v-spacer></v-spacer>
                        </v-card-actions>
                      </v-card>
                  </v-stepper-content>
                </v-stepper-items>
              </v-stepper>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="accent" v-if="step != 1" @click="stepBack">
                  Back
                </v-btn>
                <v-btn v-if="step !=4" color="primary" @click="stepUp">
                  Continue
                </v-btn>
              </v-card-actions>
            </v-container>
          </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import TaskType from "../../app/Models/TaskType";
import Task from "../../app/models/Task";
import User from "../../app/models/User";
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      step: 1,
      showing: false,
      date: [],
      task: {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        type_id: null,
        name: null,
        description: null
      },
      editing: this.$route.meta.editing,
      parent: null,
      types: [],
      users: [],
      groups: [],
      dateRules: [
        () => (this.step > 3 ? this.task.start_date != null : true),
        () => (this.step > 3 ? this.task.end_date != null : true)
      ],
      metaRules: [
        () => (this.step > 1 ? this.task.name != null : true),
        () => (this.step > 1 ? this.task.type_id != null : true)
      ]
    };
  },
  watch: {
    step() {},
    date() {
      if (this.date.length <= 2) {
        this.task.start_date = this.date[0];
        this.task.end_date = this.date[1];
      } else {
        this.date.splice(this.date.length - 1, 1);
      }
    }
  },
  computed: {
    $task() {
      return new Task(this, "task");
    },
    afterPostRedirect() {
      if (this.$route.params.task) {
        return "/tasks/" + this.$route.params.task + "/manage";
      }
      return "/tasks";
    },
    setAssignedTo() {
      var $return;
      if (this.users.length) {
        this.users.forEach(user => {
          if (user.id == this.task.user_id) {
            $return = user.name;
          }
        });
        return $return;
      }
    },
    setType() {
      var $return;
      if (this.types.length) {
        this.types.forEach(type => {
          if (type.id == this.task.type_id) {
            $return = type.name;
          }
        });
        return $return;
      }
    },
    taskUserLabel() {
      var t = this.setType;
      if (t == "Task") {
        return "User Responsible";
      }
      if (t == "Sprint" || t == "Project") {
        return "Manager";
      }
      return "Assigned To";
    }
  },
  mounted() {
    this.init();
    console.log("mounting");
  },
  methods: {
    valid(items) {
      items.forEach(item => {
        if (this.task[item] == null) {
          return true;
        }
      });
      return false;
    },
    stepUp() {
      if (this.step != 4) {
        if (this.step == 2 && this.setType == "Team") {
          this.step++;
        }
        this.step++;
      }
    },
    stepBack() {
      if (this.step != 1) {
        if (this.step == 4 && this.setType == "Team") {
          this.step--;
        }
        this.step--;
      }
    },
    init() {
      this.$root.getPage().then(() => {
        var p = this.$root.page;
        this.types = p.types;
        this.users = p.users;
        this.groups = p.groups;
        if (this.editing) {
          this.task = p.task;
          this.date = [p.task.start_date, p.task.end_date];
        }
        if (this.$route.params.task) {
          this.parent = p.parent;
        }
        this.showing = true;
      });
    },
    post() {
      if (this.editing) {
        this.update();
      } else {
        this.save();
      }
    },
    update() {
      var t = this.task;
      var data = {
        id: t.id,
        name: t.name,
        description: t.description,
        user_id: t.user_id,
        type_id: t.type_id,
        icon: t.icon,
        parent_id: t.parent_id
      };
      this.$task.update(this.task.id, data).then(() => {
        this.$router.push(this.afterPostRedirect);
      });
    },
    save() {
      this.$task.create(this.task).then(res => {
        this.reset();
        this.$router.push(this.afterPostRedirect);
      });
    },
    reset() {
      this.task = {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        type_id: null,
        name: null,
        description: null
      };
    }
  }
};
</script>