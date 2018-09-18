<template>
    <v-dialog v-model="showing" persistent fullscreen>
        <v-card scrollable>
            <v-toolbar dark color="primary">
                <h2 class="title">
                    {{post.name}}
                </h2>
                <v-spacer></v-spacer>
                <v-btn
                    icon
                    @click="remove(post.id)"
                    color="warning">
                    <v-icon>delete_forever</v-icon>
                </v-btn>
                <v-btn
                    icon
                    :to="`/${$route.params.type}/${post.id}/edit`"
                    color="success">
                    <v-icon>edit</v-icon>
                </v-btn>
                <v-btn icon :to="`/${$route.params.type}`">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text v-html="post.content">
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
      this.$post.find(this.$route.params.post);
    },
    remove(post) {
      this.$post.delete(post).then(() => {
        this.$router.push("/" + this.$route.params.type);
      });
    }
  }
};
</script>
