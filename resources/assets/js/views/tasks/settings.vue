<template>
    <v-dialog v-model="showing" :width="700">
        <v-card>
            <v-toolbar color="primary" dark>
<!--                 <v-btn
                    flat icon
                    :to="`/tasks/${$route.params.task}/manage`"
                    color="white">
                    <v-icon>chevron_left</v-icon>
                </v-btn> -->
                <h2 class="title">{{task.name}} Settings</h2>
            </v-toolbar>
            <v-card-text>
                <v-container fluid grid-list-lg>
                    <v-layout row wrap>
                        <!-- <v-flex md4>
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
                        </v-flex> -->
                        <v-flex class="relative">
                            <div class="scroll-me" v-if="task.subscribers.length">
                                <header>
                                    <h2>
                                        Users subscribed to "{{task.name}} ID: {{task.id}}".
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
                                    <v-autocomplete
                                        label="Add users to notify when something changes with this task."
                                        v-model="newSub"
                                        :search-input.sync="search"
                                        :items="users"
                                        item-text="name"
                                        item-value="id"
                                        @keyup.native.enter="addSub"
                                    ></v-autocomplete>
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
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import User from "../../app/models/User";
import TaskSetting from "../../app/models/TaskSetting";
import Task from "../../app/models/Task";
import TaskType from "../../app/models/TaskType";
export default {
  data() {
    return {
      search: null,
      task: "",
      users: [],
      types: [],
      showing: false,
      newType: {
        name: ""
      },
      newColumn: {
        value: ""
      },
      newSub: {},
      subs: []
    };
  },
  props: ["taskId"],
  computed: {
    $task() {
      return new Task(this, "task");
    },
    $setting() {
      return new TaskSetting(this, "task");
    },
    $taskType() {
      return new TaskType(this, "types");
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
    },
    search() {
      if (this.search && this.search.length > 2)
        new User(this, "users").where("name", this.search);
    }
  },
  mounted() {
    //this.init();
  },
  methods: {
    init(id = null) {
      var finalId = id == null ? this.$route.params.task : id;
      this.$task.find(finalId);
      this.showing = true;
      this.$taskType.get();
      this.$task.find(this.$route.params.task);
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
          user_id: this.newSub
        })
        .then(() => {
          if (!this.$root.errors) {
            this.$task.find(this.$route.params.task);
            this.search = "";
            this.newSub = null;
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
