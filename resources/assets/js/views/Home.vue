<template>
  <v-layout  justify-center align-center>
    <router-view></router-view>
    <v-container fluid>
      <header class=" text-xs-center">
        <icon-selector style="width: 400px" label="Select an icon" v-model="selected"></icon-selector>
      </header>
    </v-container>
  </v-layout>
</template>

<script>
import Group from "../app/models/Group";
export default {
  data() {
    return {
      user: "",
      selected: ""
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