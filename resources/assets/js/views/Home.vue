<template>
  <v-layout>
    <router-view></router-view>
    <v-container fluid grid-list-md>
      <v-container fluid grid-list-md>
        <v-layout row wrap>
          <v-flex md6>
            <ul>
              <li>
                Company Site Manager: <router-link :to="`/users/${$root.company.super_user.id}`">{{$root.company.super_user.name}}</router-link>
              </li>
            </ul>
          </v-flex>
        </v-layout>
      </v-container>
      <v-tabs v-model="tab" color="transparent">
          <v-tab href="#calendar">Calendar</v-tab>
          <v-tab href="#board">Task Board</v-tab>
        <v-tabs-items>
          <v-tab-item id="calendar">
            <v-container>
              <task-calendar v-if="user.id" owner-type="user" :owner="user.id"></task-calendar>
            </v-container>            
          </v-tab-item>
          <v-tab-item id="board">
            <v-container fluid grid-list-lg>
              <header>
                <h2 class="title">
                  {{ user.tasks ? 'Your' : 'No'}} Tasks
                </h2>
              </header>
              <v-layout row wrap>
                <div v-for="column in user.columns" :key="column.position" class="task-row flex md3 mt-2">
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
                      </div>
                    </v-card-title>
                    <v-card-text v-if="child.type.name == 'Sprint'">
                      {{child.calc_percent_finished}}% finished.
                    <div class="grey darken-1" style="padding: 0; width: 100%; height: 20px; border-radius: 50px;">
                      <div class="grey darken-2" :style="`width:${child.calc_percent_finished}%; height: 100%; border-radius: 50px;`"></div>
                    </div>
                    </v-card-text>
                    <v-card-text class="task-description" v-else v-html="child.description.shorten(200)">
                    </v-card-text>
                  </v-card>
                </div>
              </v-layout>
            </v-container>
          </v-tab-item>
        </v-tabs-items>
      </v-tabs>
    </v-container>
  </v-layout>
</template>

<script>
import Group from "../app/models/Group";
import User from "../app/models/User";
export default {
  data() {
    return {
      tab: "calendar",
      user: {
        tasks: []
      },
      selected: ""
    };
  },
  computed: {
    $user() {
      return new User(this, "user");
    }
  },
  watch: {
    $route() {
      console.log(this.$route);
    },
    user() {
      this.formatTasks();
    }
  },
  beforeMount() {},
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.user = this.$root.user;
      this.$user.find(this.$root.user.id).then(() => {
        this.user = this.user.user;
      });
    },
    formatTasks() {
      if (this.user.columns && this.user.tasks) {
        this.user.columns.forEach(column => {
          column.children = [];
          this.user.tasks.forEach(task => {
            if (task.column && task.column.value == column.value) {
              column.children.push(task);
            }
          });
        });
      }
    }
  }
};
</script>