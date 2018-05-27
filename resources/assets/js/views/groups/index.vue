<template>
    <v-container>
        <router-view></router-view>
        <h1>
            All Groups
        </h1>
    </v-container>
</template>

<script>
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      groups: []
    };
  },
  computed: {
    $groups() {
      return new Group(this, "groups");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$groups.get();
    }
  }
};
</script>
