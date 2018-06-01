<template>
    <v-container>
        <router-view></router-view>
        <h1>
            All Groups
        </h1>
    </v-container>
</template>

<script>
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      tasks: []
    };
  },
  computed: {
    $tasks() {
      return new Task(this, "tasks");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$tasks.get();
    }
  }
};
</script>
