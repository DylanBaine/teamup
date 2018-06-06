<template>
<div>
    <router-view></router-view>
    <v-dialog v-model="showing" persistent>
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn ref="exit" icon :to="$route.params.child ? `/tasks/${task.parent_id}/manage/` : `/tasks`">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">
                    {{task.name}}
                </h2>
                <v-spacer></v-spacer>
                <div v-if="!$route.params.child">
                    <v-btn
                        :to="task.parent_id ? `/tasks/${task.parent_id}/manage/${task.id}` : `/tasks/${$route.params.task}/manage`" 
                        color="success">
                    Manage
                    </v-btn>
                </div>
                <div v-else>
                    <v-btn
                        icon
                        @click="remove(task.id)"
                        color="warning">
                        <v-icon>delete_forever</v-icon>
                    </v-btn>
                    <v-btn
                        icon
                        :to="`/tasks/${task.parent_id}/manage/${task.id}/edit`"
                        color="success">
                        <v-icon>edit</v-icon>
                    </v-btn>

                </div>
            </v-toolbar>
            <v-card-text>
                <p>
                    {{task.description}}
                </p>
                <v-list>
                    <v-list-tile v-for="child in task.children" :key="child.key" :to="`/tasks/${child.id}`">
                        <v-list-tile-action>
                            <v-icon>{{child.icon}}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{child.name}}
                            </v-list-tile-title>
                            <v-list-tile-sub-title>
                                {{child.percent_finished}}% finished
                            </v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</div>
</template>

<script>
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      task: "",
      showing: false,
      tasks: ""
    };
  },
  watch: {
    $route() {
      this.init();
    }
  },
  computed: {
    $task() {
      return new Task(this, "task");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.tasks = this.$parent.tasks;
      if (this.$route.params.child) {
        this.$task.find(this.$route.params.child).then(res => {
          this.showing = true;
        });
      } else {
        this.$task.find(this.$route.params.task).then(res => {
          this.showing = true;
        });
      }
    },
    remove(id) {
      this.$refs.exit.$el.click();
      this.$parent.remove(id);
    }
  }
};
</script>
