<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
          <v-toolbar dark color="primary">
              <v-btn icon :to="$route.params.task ? `/tasks/${$route.params.task}/manage` : '/tasks/'">
                  <v-icon>chevron_left</v-icon>
              </v-btn>
          </v-toolbar>
          <v-form @submit.prevent="post()">
            <v-container grid-list-xl>
              <v-stepper v-model="step">
                <v-stepper-header>
                  <v-stepper-step :complete="step > 1" step="1">Name and assignment</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step :complete="step > 2" step="2">Timespan</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step :complete="step > 3" step="3">Details</v-stepper-step>
                  <v-divider></v-divider>
                  <v-stepper-step step="3">Confim and Save</v-stepper-step>
                </v-stepper-header>
                <v-stepper-items>
                  <v-stepper-content step="1">
                    <div class="padded">
                      <v-layout row wrap justify-center>
                        <v-flex md8>
                          <v-text-field
                            label="Name"
                            v-model="task.name"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                      <v-layout row wrap justify-center>
                        <v-flex md4>
                          <v-select
                            autocomplete
                            label="Assigned To"
                            :items="users"
                            item-value="id"
                            item-text="name"
                            v-model="task.user_id"
                            hint="Start typing to find a user.">
                          </v-select>
                        </v-flex>
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
                      </v-layout>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content step="2">
                    <div class="padded">
                      <div>
                        <v-layout row wrap justify-center>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div>
                              <h3>Start:</h3>
                              <v-date-picker v-model="task.start_date" color="primary white--text"></v-date-picker>
                            </div>
                          </v-flex>
                          <v-flex md4 style="display: flex; justify-content: center;">
                            <div>
                              <h3>End:</h3>
                              <v-date-picker v-model="task.end_date" color="primary white--text"></v-date-picker>
                            </div>
                          </v-flex>
                        </v-layout>     
                      </div>
                    </div>
                  </v-stepper-content>
                  <v-stepper-content step="3">
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
                            <v-text-field
                              multi-line
                              label="Description"
                              v-model="task.description"
                            ></v-text-field>
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
                          <v-layout row wrap class="mt-4">
                            <v-flex class="padded" md3>
                              <h4>Start: {{task.start_date}}</h4>
                            </v-flex>
                            <v-flex class="padded" md3>
                              <h4>End: {{task.start_date}}</h4>
                            </v-flex>
                          </v-layout>
                        </v-card-text>
                      </v-card>
                  </v-stepper-content>
                </v-stepper-items>
              </v-stepper>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="accent" @click="step--">
                  Back
                </v-btn>
                <v-btn color="primary" @click="step++">
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
export default {
  data() {
    return {
      step: 1,
      showing: false,
      task: {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        type_id: null,
        name: null,
        description: null
      },
      editing: this.$route.meta.editing,
      search: "",
      types: [],
      users: [],
      afterPostRedirect: "/tasks/" + this.$route.params.task + "/manage"
    };
  },
  watch: {
    step() {
      if (this.step > 4) this.post();
    }
  },
  computed: {
    $types() {
      return new TaskType(this, "types");
    },
    $task() {
      return new Task(this, "task");
    },
    $users() {
      return new User(this, "users");
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
    }
  },
  mounted() {
    this.init();
    console.log("mounting");
  },
  methods: {
    init() {
      if (this.editing) {
        this.$task.find(this.$route.params.task);
      }
      this.$types.get().then(() => {
        this.$users.get().then(() => {
          this.showing = true;
        });
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