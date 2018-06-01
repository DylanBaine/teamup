<template>
    <v-container grid-list-lg>
        <router-view></router-view>
        <header>
            <h1>
                {{type.name}}
            </h1>
        </header>
        <section>
            <v-layout row wrap>
                <v-flex md6 v-for="post in type.posts" :key="post.id">
                    <v-card hover :to="`/${$route.params.type}/${post.id}`">
                        <v-card-title class="grey lighten-2">
                            <h2 class="title black--text">
                                {{post.name}}
                                <h6 class="mt-1 subheading black--text">{{post.content.length}} characters</h6>
                            </h2>
                        </v-card-title>
                        <v-card-text>
                            {{post.content.substr(0, 200)}}
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </section>
		<v-btn
            v-if="$user.can('create', $route.params.type)"
			fab
			bottom
			right
			color="pink"
			dark
			fixed
			:to="`/${$route.params.type}/create`">
			<v-icon>add</v-icon>
		</v-btn>
    </v-container>
</template>

<script>
import Type from "../../app/models/PostType";
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
      return this.$root.$refs.app.$user;
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
      if (this.type == null || this.type.slug != this.$route.params.type) {
        this.$type.find("slug", this.$route.params.type);
      }
    }
  }
};
</script>
