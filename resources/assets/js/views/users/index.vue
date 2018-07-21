<template>
    <div class="container">
        <router-view></router-view>
        <v-container grid-list-md>
            <header>
                <h1>
                    All Users
                </h1>
            </header>
            <v-layout row wrap>
                <v-flex v-for="user in users" :key="user.id" md4>
                    <v-card class="grey lighten-2 black--text" :to="`/users/${user.id}`">
                        <v-card-text>
                            <h2 class="title">
                                {{user.name}}
                            </h2>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
import User from "../../app/models/User.js";
export default {
  data() {
    return {
      users: []
    };
  },
  computed: {
    $users() {
      return new User(this, "users");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$users.get();
    }
  }
};
</script>