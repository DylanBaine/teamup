<template>
  <v-container fluid grid-list-lg>
    <router-view></router-view>
    <h1>
      All Groups
    </h1>
    <v-layout row wrap>
      <v-flex md6 v-for="group in groups.collection" :key="group.key">
        <v-card ripple :to="`/groups/${group.id}`">
          <v-card-title class="grey lighten-2">
            <h2 class="title black--text">
              {{group.name}}
            </h2>
          </v-card-title>
        </v-card>
      </v-flex>
    </v-layout>
    <v-btn
      v-if="$user.can('create', 'groups')"
      fab
      bottom
      right
      color="pink"
      dark
      fixed
      :to="`/groups/create`">
      <v-icon>add</v-icon>
    </v-btn>
  </v-container>
</template>

<script>
import Group from "../../app/models/Group";
import User from "../../app/models/User";
export default {
  data() {
    return {
      groups: []
    };
  },
  computed: {
    $groups() {
      return new Group(this, "groups");
    },
    $user() {
      return new User(this.$root, "user");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.groups = new Group().get();
      //this.$groups.get();
    }
  }
};
</script>
