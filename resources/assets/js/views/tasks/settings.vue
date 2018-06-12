<template>
    <v-dialog fullscreen v-model="showing" transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar color="primary" dark>
                <v-btn
                    flat icon
                    :to="`/tasks/${$route.params.task}/manage`"
                    color="white">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">{{task.name}} Settings</h2>
            </v-toolbar>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex md4>
                        <div ref="scrollMe" class="scroll-me" v-if="task.columns && task.columns.length">
                            <header>
                                <h2>
                                    Task columns.
                                </h2>
                            </header>
                            <v-list ref="columnList">
                                <draggable v-model="task.columns" :items="task.columns" @end="changeColumnOrder">
                                    <div :id="column.id" v-for="column in task.columns" :key="column.position">
                                        <v-list-tile>
                                            <v-list-tile-content>
                                                <input type="text" class="padded ghost" @keydown.enter="$setting.update(column.id, column)" v-model="column.value">
                                            </v-list-tile-content>
                                            <v-list-tile-action>
                                                <v-btn @click="removeColumn(column.id)" icon flat small color="grey">
                                                    <v-icon>delete_forever</v-icon>
                                                </v-btn>
                                            </v-list-tile-action>
                                            <v-list-tile-action>
                                                <v-btn flat icon><v-icon color="grey">drag_indicator</v-icon></v-btn>
                                            </v-list-tile-action>
                                        </v-list-tile>
                                    </div>
                                </draggable>
                            </v-list>
                        </div>
                        <div class="relative">
                            <v-text-field
                                @keyup.native.enter="addColumn"
                                label="Add a task column."
                                v-model="newColumn.value"
                            ></v-text-field>
                            <v-btn
                                absolute
                                @click="addColumn"
                                color="primary"
                                fab bottom right>
                                <v-icon>add</v-icon>
                            </v-btn>
                        </div>
                    </v-flex>
                    <v-flex md7 offset-md1 class="relative">
                        <div class="scroll-me" v-if="task.subscribers.length">
                            <header>
                                <h2>
                                    Users subscribed to {{task.name}}.
                                </h2>
                            </header>
                            <v-list>
                                <v-list-tile v-for="subbed in task.subscribers" :key="subbed.key">
                                    <v-list-tile-content>
                                        <v-list-tile-title>
                                            {{subbed.user.name}}
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-btn flat icon @click="removeSubscriber(subbed.id)"><v-icon color="grey">delete_forever</v-icon></v-btn>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                        </div>
                        <div class="relative">
                            <div>
                                <v-select
                                    label="Add users to notify when something changes with this task."
                                    v-model="newSub"
                                    :search-input.sync="search"
                                    autocomplete
                                    :items="users"
                                    item-text="name"
                                    @keyup.native.enter="addSub"
                                ></v-select>
                            </div>
                            <v-btn
                                absolute
                                @click="addSub"
                                color="primary"
                                fab bottom right>
                                <v-icon>add</v-icon>
                            </v-btn>
                        </div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
import User from "../../app/models/User";
import TaskSetting from "../../app/models/TaskSetting";
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      search: null,
      task: this.$parent.task,
      users: [],
      showing: false,
      newColumn: {
        value: ""
      },
      newSub: {},
      subs: []
    };
  },
  computed: {
    $task() {
      return new Task(this, "task");
    },
    $setting() {
      return new TaskSetting(this, "task");
    },
    newColumnPosition() {
      return this.task.columns.length + 1;
    }
  },
  watch: {
    columns() {
      var el = this.$refs.scrollMe;
      var list = this.$refs.columnList.$el;
      var scrollPos = el.scrollHeight + list.clientHeight;
      el.scrollTop = scrollPos;
      console.log(list.clientHeight);
    },
    search() {
      if (this.search && this.search.length > 2)
        new User(this, "users").where("name", this.search);
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      if (this.task == "") this.$task.find(this.$route.params.task);
      this.showing = true;
    },
    addColumn() {
      this.$setting
        .addColumn({
          value: this.newColumn.value,
          position: this.newColumnPosition
        })
        .then(() => {
          if (!this.$root.errors) {
            this.$task.find(this.$route.params.task);
            this.newColumn = {
              value: "",
              position: this.newColumnPosition
            };
          }
        });
    },
    removeColumn(column) {
      this.$setting.removeColumn(column).then(() => {
        if (!this.$root.errors) {
          this.$task.find(this.$route.params.task);
        }
      });
    },
    addSub() {
      this.$setting
        .subscribeUserToTask({
          subscribable_id: this.task.id,
          subscribable_type: "App\\Models\\Task",
          user_id: this.newSub.id
        })
        .then(() => {
          if (!this.$root.errors) {
            this.$task.find(this.$route.params.task);
            this.search = "";
            this.newSub = {
              name: ""
            };
          }
        });
    },
    removeSubscriber(setting) {
      this.$setting.removeSubscriber(setting).then(() => {
        this.$task.find(this.$route.params.task);
      });
    },
    changeColumnOrder(e) {
      this.task.columns.forEach((column, i) => {
        column.position = i + 1;
        this.$setting.update(column.id, column, "quick");
      });
    }
  }
};
</script>

<style scoped>
.scroll-me {
  max-height: 300px;
  overflow: auto;
}
</style>
