<template>
    <v-container grid-list-lg>
        <router-view></router-view>
        <header>
            <h1>
                Post Types
            </h1>
        </header>
        <section>
            <v-layout row wrap>
                <v-flex md6 v-for="type in types" :key="type.id">
                    <v-card hover>
                        <v-card-title class="grey lighten-2">
                            <h2 class="title black--text">
                                <label :for="type.id+type.slug">
                                        <v-icon color="black">edit</v-icon>
                                </label>
                                <input :id="type.id+type.slug" @keyup.enter="$types.update(type.id, type)" type="text" class="padded ghost" v-model="type.name">
                            </h2>
                            <v-spacer></v-spacer>
                            <v-btn icon flat @click="remove(type)" color="black">
                                <v-icon>delete_forever</v-icon>
                            </v-btn>
                        </v-card-title>
                    </v-card>
                </v-flex>
            </v-layout>
        </section>
            <div class="fixed bottom right">
                <v-btn fab dark v-if="$user.can('create', 'post-types')"
                    to="/post-types/create" color="accent">
                    <v-icon>add</v-icon>
                </v-btn>
            </div>
    </v-container>
</template>

<script>
import Type from "../../app/models/PostType";
import User from "../../app/models/User";
export default {
  data() {
    return {
      types: null,
      fam: false
    };
  },
  computed: {
    $types() {
      return new Type(this, "types");
    },
    $user() {
      return new User(this.$root, "user");
    }
  },
  watch: {
    $route() {
      this.init();
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$types.get();
    },
    remove(type) {
      this.$types.delete(type.id);
    }
  }
};
</script>
