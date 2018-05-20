<template>
    <v-card width="800px">
        <v-alert type="error" v-if="error" :value="true">
            <h3 class="text-xs-center">
                {{error}}
            </h3>
        </v-alert>
        <v-form :valid="valid" @submit.prevent="login()">
            <v-card-text v-if="$root.AuthUser" class="text-xs-center">
                <h1>Hey, {{$root.AuthUser.name}}! You are already logged in.</h1>
            </v-card-text>
            <v-card-text v-if="!$root.AuthUser">
                <div>
                    <v-text-field
                        v-model="user.email"
                        label="Email"
                        type="email"
                    ></v-text-field>
                    <br>
                    <v-text-field
                        v-model="user.password"
                        label="Password"
                        type="password"
                    ></v-text-field>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer v-if="!$root.AuthUser"></v-spacer>
                <v-btn v-if="$root.AuthUser" block color="success" to="/">Go Home</v-btn>
                <v-btn v-if="!$root.AuthUser" type="submit" color="primary">Login</v-btn>
            </v-card-actions>
        </v-form>
    </v-card>
</template>

<script>
import GuestMiddleware from "../../app/middleware/GuestMiddleware";
import User from "../../app/models/User";
export default {
  data() {
    return {
      middleware: {},
      valid: false,
      user: {
        email: "",
        password: ""
      },
      model: {},
      error: ""
    };
  },
  watch: {
    $router() {
      this.middleware.check();
    }
  },
  created() {
    this.middleware = new GuestMiddleware(this);
  },
  mounted() {
    this.middleware.check();
    this.model = new User(this);
  },
  methods: {
    login() {
      this.model.login(this.user);
    },
    handleResponse(user, error) {
      this.$root.AuthUser = user;
      this.error = error;
    }
  }
};
</script>

<style scoped>
</style>