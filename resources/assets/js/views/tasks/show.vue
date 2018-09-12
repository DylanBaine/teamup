<template>
<div>
    <v-dialog v-model="showing" :width="700">
        <v-card>
            <v-toolbar dark color="primary">
                <h2 class="title">
                    {{task.name}} 
                </h2>
                <h3 class="subheading">
                    ID: {{task.id}}
                </h3>
                <v-spacer></v-spacer>
                <v-btn flat :to="`/tasks/${task.id}/manage`" color="white">Manage</v-btn>
                <v-btn flat icon color="white">
                    <v-icon @click="showing = false">close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <v-card flat>
                    <p v-html="task.description"></p>
                    <h3 class="subheader" v-if="task.user_id">Assigned To: {{task.user.name}}</h3>
                    <v-list>
                        <v-list-tile v-for="child in task.children" :key="child.key" :to="`/tasks/${child.id}/manage`">
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
                </v-card>
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
  props: ["taskId"],
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
  methods: {
    init(id = null) {
      var finalId = id == null ? this.$route.params.task : id;
      this.$task.find(finalId).then(res => {
        this.showing = true;
      });
    },
    remove(id) {
      this.$refs.exit.$el.click();
      this.$parent.remove(id);
    }
  }
};
</script>
