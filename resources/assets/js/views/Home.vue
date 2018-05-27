<template>
  <v-layout  justify-center align-center>
    <router-view></router-view>
    <v-container fluid>
      <header class=" text-xs-center">
        <h1 class="display-4">
          Welcome back, {{user.name}}!
        </h1>
        <h2 class="display-3">
          Eventually we will put relevent content here...
        </h2>
      </header>
    </v-container>
  </v-layout>
</template>

<script>
import Group from "../app/models/Group";
export default {
  data() {
    return {
      user: ""
    };
  },
  computed: {},
  beforeMount() {},
  mounted() {
    this.user = this.$root.user;
  },
  methods: {}
};
</script>