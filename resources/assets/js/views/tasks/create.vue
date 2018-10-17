<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
          <v-toolbar dark color="primary">
            <h2 class="title" v-if="!editing && parent">
              Creating a child of {{parent.name}}
            </h2>
            <h2 class="title" v-else-if="editing">
              Editing {{task.name}}
            </h2>
            <h2 class="title" v-else>
              Creating a new Task
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
                        <v-flex md6 v-if="editing">
                          <v-autocomplete
                            label="Parent"
                            :items="parent_options"
                            v-model="task.parent_id"
                            item-value="id"
                            item-text="name"
                          ></v-autocomplete>
                        </v-flex>
                      </v-layout>
                      <v-layout row wrap justify-center>
                        <v-flex md4>
                          <v-select
                            v-model="task.type_id"
                            label="Type"
                            :items="types"
                            item-avatar="icon"
                            item-text="name"
                            persistent-hint
                            hint="A sprint task type will generate progress columns."
                            item-value="id">
                          </v-select>
                        </v-flex>
                        <v-flex md4 v-if="$root.$user.can('assign', 'tasks') || $root.$user.can('manage', 'tasks')">
                            <v-autocomplete
                              v-if="setType != 'Team'"
                              :label="taskUserLabel"
                              :items="users"
                              item-value="id"
                              item-text="name"
                              v-model="task.user_id"
                              @input="getUsersAvailability"
                              hint="Start typing to find a user.">
                            </v-autocomplete>
                            <v-autocomplete
                              v-else
                              label="Group"
                              :items="groups"
                              item-value="id"
                              item-text="name"
                              v-model="task.group_id"
                              @input="task.name = setGroup"
                              hint="Start typing to find a group.">
                            </v-autocomplete>
                        </v-flex>
                      </v-layout>
                      <v-layout row wrap justify-center>
                        <v-flex md4 v-if="setType == 'Project'">
                          <v-autocomplete
                            label="Client"
                            v-model="task.client_id"
                            :items="clients"
                            item-text="name"
                            item-value="id"
                          ></v-autocomplete>
                        </v-flex>
                        <v-flex :md8="setType != 'Project'" :md4="setType == 'Project'">
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
                          <v-flex md8 offset-md2>
                            <v-layout v-if="setType == 'Reoccurring'">
                              <v-flex md4>
                                <v-select
                                  @input="reoccurOnOptions()"
                                  label="Reoccurring Type"
                                  v-model="reoccur.type"
                                  :items="[
                                    'Daily', 'Weekly', 'Monthly'
                                  ]"
                                ></v-select>
                              </v-flex>
                              <template v-if="reoccur.type == 'Monthly'">
                                <v-flex md4>
                                  <v-select
                                    label="Week:"
                                    v-model="reoccur.week"
                                    :items="reoccurOnOptions()"
                                  ></v-select>
                                </v-flex>
                                <v-flex md4>
                                  <v-select
                                    label="Day:"
                                    v-model="reoccur.day"
                                    :items="reoccurOnOptions('Weekly')"
                                  ></v-select>
                                </v-flex>
                                <v-flex md4>
                                  <v-select
                                    label="Time:"
                                    v-model="reoccur.time"
                                    :items="reoccurOnOptions('Daily')"
                                  ></v-select>
                                </v-flex>
                              </template>
                              <template v-if="reoccur.type == 'Weekly'">
                                <v-flex md4>
                                  <v-select
                                    label="Day:"
                                    v-model="reoccur.day"
                                    :items="reoccurOnOptions()"
                                  ></v-select>
                                </v-flex>
                                <v-flex md4>
                                  <v-select
                                    label="Time:"
                                    v-model="reoccur.time"
                                    :items="reoccurOnOptions('Daily')"
                                  ></v-select>
                                </v-flex>
                              </template>
                              <template v-if="reoccur.type == 'Daily'">
                                <v-flex md4>
                                  <v-select
                                    label="Time:"
                                    v-model="reoccur.time"
                                    :items="reoccurOnOptions('Daily')"
                                  ></v-select>
                                </v-flex>
                              </template>
                            </v-layout>
                          </v-flex>
                          <v-flex md6>
                            <icon-selector
                              label="Select an icon"
                              v-model="task.icon"
                            ></icon-selector>
                          </v-flex>
                          <v-flex md6>
                            <page-builder
                              label="Description"
                              v-model="task.description"
                            ></page-builder>
                          </v-flex>
                        </v-layout>
                      </div>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content v-if="setType != 'Team'" step="3">
                    <div class="padded">
                      <div v-if="user_tasks.length" class="text-xs-center">
                        <div style="background: red; width: 10px; height: 10px; display: inline-block; border-radius: 100%;"></div>
                        marks days that user has tasks.
                      </div>
                        <v-layout row wrap justify-center>
                          <v-flex md2 v-if="user_tasks.length">
                            <h2 class="title text-xs-center">
                              Users other task dates.
                            </h2>
                            <hr>
                            <ul class="scroll-180px">
                              <li v-for="task in user_tasks" :key="task.start_date">
                                <ul>
                                  <h4>{{task.name}}</h4>
                                  <li>
                                    {{task.type.name}}
                                  </li>
                                  <li>
                                    Start: {{task.start_date_string}}
                                  </li>
                                  <li>
                                    End: {{task.end_date_string}}
                                  </li>
                                </ul>
                              </li>
                            </ul>
                          </v-flex>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div>
                              <h3>Start:</h3>
                              <v-date-picker :events="events" event-color="red" v-model="task.start_date" :min="parent ? parent.start_date : null" :max="task.end_date ? task.end_date : parent ? parent.end_date : null" color="primary white--text"></v-date-picker>
                            </div>
                          </v-flex>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div>
                              <h3>End:</h3>
                              <v-date-picker :events="events" event-color="red" v-model="task.end_date" :min="task.start_date ? task.start_date : parent ? parent.start_date : null" :max="parent ? parent.end_date : null" color="primary white--text"></v-date-picker>
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
                            <v-flex md3 class="padded" v-if="task.group">
                              <h4>Assigned To: {{setAssignedTo}} {{task.group_id ? task.group.name : ''}}</h4>
                            </v-flex>
                          </v-layout>
                          <v-layout v-if="setType != 'Team'" row wrap class="mt-4">
                            <v-flex class="padded" md3>
                              <h4>Start: {{task.start_date}}</h4>
                            </v-flex>
                            <v-flex class="padded" md3>
                              <h4>End: {{task.end_date}}</h4>
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
import TaskType from "../../app/models/TaskType";
import Task from "../../app/models/Task";
import User from "../../app/models/User";
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      step: 1,
      showing: false,
      allowedDates: [],
      events: [],
      reoccur: {
        week: null,
        day: null,
        time: null,
        type: null
      },
      task: {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        group_id: null,
        type_id: null,
        name: null,
        description: null,
        group: null,
        user: null
      },
      clients: [],
      editing: this.$route.meta.editing,
      parent: {
        start_date: null,
        end_date: null
      },
      types: [],
      user_tasks: [],
      users: [],
      groups: [],
      dateRules: [
        () => (this.step > 3 ? this.task.start_date != null : true),
        () => (this.step > 3 ? this.task.end_date != null : true)
      ],
      metaRules: [
        () => (this.step > 1 ? this.task.name != null : true),
        () => (this.step > 1 ? this.task.type_id != null : true)
      ],
      parent_options: []
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
    setGroup() {
      var group = this.groups.filter(group => {
        return group.id == this.task.group_id;
      })[0];
      return group ? group.name : null;
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
  },
  methods: {
    reoccurOnOptions(typeArg = null) {
      let type = typeArg == null ? this.reoccur.type : typeArg;
      switch (type) {
        case "Daily":
          return [
            { text: "Morning (8 AM)", value: "08:00" },
            { text: "After Noon (1 PM)", value: "13:00" },
            { text: "Evening (5 PM)", value: "17:00" }
          ];
        case "Weekly":
          return [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
          ];
        case "Monthly":
          return ["First", "Second", "Third", "Fourth", "Last"];
      }
    },
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
        console.log(p);
        this.parent = p.parent;
        this.types = p.types;
        this.users = p.users;
        this.groups = p.groups;
        this.clients = p.clients;
        if (this.editing) {
          this.task = p.task;
          if (p.task.type.name == "Reoccurring") {
            this.reoccur = p.task.schedule;
          }
          this.parent_options = p.parent_options;
          this.date = [p.task.start_date, p.task.end_date];
        }
        /* if (this.$route.params.task) {
            this.parent = p.parent;
          } */
        this.showing = true;
      });
      this.$root.mounted = true;
    },
    post() {
      let type = this.reoccur.type;
      if (type == "Daily") {
        this.reoccur.day = null;
        this.reoccur.week = null;
      } else if (type == "Weekly") {
        this.reoccur.week = null;
      }
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
        group_id: t.group_id,
        parent_id: t.parent_id,
        start_date: t.start_date,
        end_date: t.end_date,
        client_id: t.client_id,
        schedule: JSON.stringify(this.reoccur)
      };
      this.$task.update(this.task.id, data).then(() => {
        this.$router.push(this.afterPostRedirect);
      });
    },
    save() {
      this.task.schedule = JSON.stringify(this.reoccur);
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
    },
    getUsersAvailability() {
      axios
        .get(url + "/tasks/user_availability/" + this.task.user_id)
        .then(res => {
          this.user_tasks = res.data.tasks;
          this.events = res.data.events;
        });
    }
  }
};
</script>