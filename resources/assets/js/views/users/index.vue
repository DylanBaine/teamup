<template>
    <div class="container fluid" style="padding: 0;">
        <router-view></router-view>
        <v-container fluid grid-list-md>
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
                            <p>{{user.email}}</p>
                            <p>
                                Task Count: {{user.tasks.length}}
                            </p>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <div class="fixed bottom right">
            <v-btn fab color="accent" to="/users/create">
                <v-icon>add</v-icon>
            </v-btn>
        </div>
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
  watch: {
    $route() {
      this.init();
    }
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