<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon :to="`/${$route.params.type}`">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">
                    {{post.name}}
                </h2>
            </v-toolbar>
            <v-card-text>
                {{post.content}}
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn flat color="error" v-if="$parent.$user.can('delete', $route.params.type)">
                        Delete
                    </v-btn>
                    <v-btn flat color="warning" v-if="$root.$refs.app.$user.can('update', $route.params.type)">
                        Edit
                    </v-btn>
                </v-card-actions>
            </v-card-text>        
        </v-card>
    </v-dialog>
</template>

<script>
import Post from "../../app/models/Post";
export default {
  data() {
    return {
      post: {},
      showing: false
    };
  },
  computed: {
    $post() {
      return new Post(this, "post");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.showing = true;
      this.$post.find("id", this.$route.params.post);
    }
  }
};
</script>
