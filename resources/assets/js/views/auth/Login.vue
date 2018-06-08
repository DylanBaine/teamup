<template>
<v-app>
  <v-layout justify-center align-center>
    <div>
        <v-card width="800px">
            <v-form :valid="valid" @submit.prevent="login()">
                <v-card-text>
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
                    <v-btn type="submit" color="primary">Login</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
      <v-fade-transition>
          <v-alert type="error" v-if="error" :value="true">
              <h3 class="text-xs-center">
                  {{error}}
              </h3>
          </v-alert>
      </v-fade-transition>
    </div>
  </v-layout>
	<loader ref="loader"></loader>
</v-app>
</template>

<script>
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
      error: "",
      fresh: false
    };
  },
  watch: {
    error() {
      setTimeout(() => {
        this.error = false;
      }, 2000);
    }
  },
  created() {},
  mounted() {
    this.model = new User(this);
  },
  methods: {
    login() {
      this.model.login(this.user);
    },
    handleResponse(user, error) {
      this.$root.AuthUser = user;
      this.error = error;
    },
    showLoader(message) {
      this.$refs.loader.run(message);
    }
  }
};
</script>

<style scoped>
</style>