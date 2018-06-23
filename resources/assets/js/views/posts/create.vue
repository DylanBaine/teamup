<template>
    <v-dialog fullscreen hide-overlay v-model="showing" persistent>
        <v-card>
            <v-form @submit.prevent="save()">
                <v-toolbar dark color="primary">
                    <v-btn icon :to="`/${$route.params.type}`">
                        <v-icon>chevron_left</v-icon>
                    </v-btn>
                    <h2 class="title">
                        Create new {{$parent.type.name}}.
                    </h2>
                </v-toolbar>  
                <v-card-text>
                    <v-text-field
                        label="Post Title"
                        v-model="post.name"
                    ></v-text-field>
                    <page-builder label="Content" v-model="post.content" v-if="showing"></page-builder>
                    <v-card-actions class="mt-2">
                        <v-spacer></v-spacer>
                        <v-btn :to="`/${$route.params.type}`" color="error" flat>
                            Cancel
                        </v-btn>
                        <v-btn color="success" flat type="submit">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card-text>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import Post from "../../app/models/Post";
import PostType from "../../app/models/PostType";
export default {
  data() {
    return {
      showing: false,
      post: {
        name: "",
        content: "",
        type_id: this.$parent.type.id
      }
    };
  },
  computed: {
    $post() {
      return new Post(this, "post");
    },
    $type() {
      return new PostType(this.$parent, "types");
    }
  },
  watch: {
    $route() {
      this.$parent.$mount();
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      if (this.$route.meta.editing) {
        this.$post.find(this.$route.params.post);
      }
      this.showing = true;
    },
    save() {
      if (this.$route.meta.editing) {
        this.$post.update(this.post.id, this.post);
      } else {
        this.$post.create(this.post).then(() => {
          this.reset();
        });
      }
    },
    reset() {
      this.post = {
        name: "",
        content: "",
        type_id: this.$parent.type.id
      };
    }
  }
};
</script>
