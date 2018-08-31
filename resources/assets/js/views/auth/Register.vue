<template>
  <div>
      <v-card style="margin: auto;" class="elevation-6" width="800px">
          <v-card-title>
              <h2 class="title">
                  Register
              </h2>
              <v-spacer></v-spacer>
              <v-btn small color="accent" :href="$root.url+'/login'">or login</v-btn>
          </v-card-title>
          <v-divider></v-divider>
          <v-form :valid="valid" method="POST" :action="$root.url+'/auth/register'">
              <input type="hidden" name="_token" :value="$root.csrf_token">
              <v-card-text>
                  <div>
                      <v-text-field
                          v-model="user.email"
                          name="email"
                          label="Email"
                          type="email"
                      ></v-text-field>
                      <br>
                      <v-text-field
                        v-model="user.name"
                        label="Name"
                        name="name"
                      ></v-text-field>
                      <br>
                      <v-text-field
                          v-model="user.password"
                          label="Password"
                          type="password"
                          name="password"
                      ></v-text-field>
                      <br>
                      <v-text-field
                          v-model="user.companyName"
                          label="Company Name"
                          name="companyName"
                      ></v-text-field>
                  </div>
              </v-card-text>
              <v-card-actions>
                  <v-btn type="submit" color="primary">get started</v-btn>
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
      <loader ref="loader"></loader>
    </div>
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
        name: "",
        password: "",
        companyName: ""
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
    register() {
      this.model.register(this.user);
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