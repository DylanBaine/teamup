<template>
    <div>
        <v-card class="elevation-6" style="margin: auto;" width="800px">
          <v-card-title>
            <h2 class="title">
              Login
            </h2>
            <v-spacer></v-spacer>
            <v-btn small color="accent" :href="$root.url+'/register'">or register</v-btn>
          </v-card-title>
          <v-divider></v-divider>
            <v-form :valid="valid" :action="$root.url+'/auth/login'" method="POST">
                <input type="hidden" name="_token" :value="$root.csrf_token">
                <v-card-text>
                    <div>
                        <v-text-field
                            v-model="user.email"
                            label="Email"
                            type="email"
                            name="email"
                        ></v-text-field>
                        <br>
                        <v-text-field
                            v-model="user.password"
                            label="Password"
                            type="password"
                            name="password"
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