<template>
    <v-container fluid grid-list-lg>
        <router-view></router-view>
        <header>
            <h1 v-if="type">
                {{type.name}}
            </h1>
        </header>
        <section>
            <v-layout row wrap v-if="type">
                <v-flex md6 v-for="post in type.posts" :key="post.id">
                    <v-card hover :to="`/${$route.params.type}/${post.id}`">
                        <v-card-title class="grey lighten-2">
                            <h2 class="title black--text">
                                {{post.name}}
                            </h2>
                        </v-card-title>
                        <v-card-text v-html="post.content.shorten()"></v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </section>
    </v-container>
</template>

<script>
import Type from "../../app/models/PostType";
import User from "../../app/models/User";
export default {
  data() {
    return {
      type: null
    };
  },
  computed: {
    $type() {
      return new Type(this, "type");
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
      this.$root.getPage().then(() => {
        let p = this.$root.page;
        this.type = p;
      });
    }
  }
};
</script>
