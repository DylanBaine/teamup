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
                        <div ref="scrollMe" class="scroll-me" v-if="columns.length">
                            <header>
                                <h2>
                                    Task columns.
                                </h2>
                            </header>
                            <v-list ref="columnList">
                                <v-list-tile v-for="column in columns" :key="column.position">
                                    <v-list-tile-content>
                                        {{column.name}}
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-icon color="grey">drag_indicator</v-icon>
                                    </v-list-tile-action>
                                </v-list-tile>
                            </v-list>
                        </div>
                        <div class="relative">
                            <v-text-field
                                @keyup.native.enter="addColumn"
                                label="Add a task column."
                                v-model="newColumn.name"
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
                        <div class="scroll-me" v-if="subs.length">
                            <header>
                                <h2>
                                    Users subscribed to {{task.name}}.
                                </h2>
                            </header>
                            <v-list>
                                <v-list-tile v-for="subbed in subs" :key="subbed.key">
                                    <v-list-tile-content>
                                        {{subbed.name}}
                                    </v-list-tile-content>
                                    <v-list-tile-action v-if="columns.length">
                                        <v-menu>
                                            <v-btn slot="activator" color="accent" icon>
                                                <v-icon>more_vert</v-icon>
                                            </v-btn>
                                            <v-card>
                                                <v-card-title>
                                                    Choose a specific column to subscribe {{subbed.name}} to.
                                                </v-card-title>
                                                <div ref="scrollMe" class="scroll-me">
                                                    <v-list ref="columnList">
                                                        <v-list-tile v-for="column in columns" :key="column.position" @click="subscribeUserToColumn(subbed.id, column.name)">
                                                            <v-list-tile-content>
                                                                {{column.name}}
                                                            </v-list-tile-content>
                                                        </v-list-tile>
                                                    </v-list>
                                                </div>
                                            </v-card>
                                        </v-menu>
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
export default {
  data() {
    return {
      search: null,
      task: this.$parent.task,
      users: [],
      showing: false,
      newColumn: {
        name: "",
        position: 1
      },
      columns: [],
      newSub: {},
      subs: []
    };
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
      if (this.search.length > 2)
        new User(this, "users").where("name", this.search);
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      if (this.task == "")
        this.$router.push(`/tasks/${this.$route.params.task}/manage`);
      this.showing = true;
    },
    addColumn() {
      new TaskSetting(this, "task").addColumn(this.newColumn);
      this.columns.push(this.newColumn);
      this.newColumn = {
        name: "",
        position: this.columns.length + 1
      };
    },
    addSub() {
      new TaskSetting(this, "task").create({
        user_id: this.newSub.id
      });
      this.subs.push(this.newSub);
      this.search = "";
      this.newSub = {
        name: ""
      };
    },
    subscribeUserToColumn(user, column) {
      new TaskSetting(this, "task").subscribeUserToColumn({
        user_id: user,
        column: column
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