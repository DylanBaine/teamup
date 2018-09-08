<template>
    <v-dialog
        v-model="showing"
        transition="dialog-transition">
        <v-card>
            <v-toolbar color="primary">
                <h2 class="title">New User</h2>
                <v-spacer></v-spacer>
                <v-btn flat icon color="white" to="/users">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <v-form @submit.prevent="post()">
                    <v-container fluid grid-list-lg>
                        <v-layout row wrap>
                            <v-flex md6>
                                <v-text-field
                                    label="Name"
                                    v-model="user.name"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md6>
                                <v-text-field
                                    label="E-mail"
                                    v-model="user.email"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" type="submit">Save</v-btn>
                        </v-card-actions>
                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import User from "../../app/models/User";
export default {
  data() {
    return {
      user: {
        name: "",
        email: ""
      },
      showing: false
    };
  },
  computed: {
    $user() {
      return new User(this.$root, "users");
    }
  },
  mounted() {
    this.showing = true;
  },
  methods: {
    post() {
      this.$user.create(this.user).then(() => {
        this.user = {
          name: "",
          email: ""
        };
      });
    }
  }
};
</script>
