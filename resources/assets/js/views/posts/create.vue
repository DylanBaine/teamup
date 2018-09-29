<template>
    <v-dialog fullscreen hide-overlay v-model="showing" persistent>
        <v-card v-if="post">
            <v-form ref="form" @submit.prevent="save()" :valid="valid">
                <v-toolbar dark color="primary" v-if="!$route.meta.forSite">
                    <h2 class="title" v-if="type">
                        Create new {{type.name}}.
                    </h2>
                    <v-spacer></v-spacer>
                    <v-btn icon :to="`/${$route.params.type}`">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-toolbar>  
                <v-card-text>
                    <v-text-field
                        :label="'Post Title'"
                        v-model="post.name"
                        required
                        :rules="[post.name.length > 0 && post.name.length < 100]"
                    ></v-text-field>
                    <page-builder label="Content" v-model="post.content" height="600"></page-builder>
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
      type: null,
      valid: false,
      post: {
        name: "",
        content: "",
        type_id: "",
        type_name: "",
        model: "Post"
      }
    };
  },
  computed: {
    $post() {
      return new Post(this, "post");
    },
    $type() {
      return new PostType(this, "type");
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
      this.$root.getPage().then(() => {
        let p = this.$root.page;
        this.type = p.type;
        if (this.$route.meta.editing) {
          this.post = p.post;
        }
        this.post.type_id = this.type.id;
        this.showing = true;
      });
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.$route.meta.editing) {
          this.$post.update(this.post.id, this.post).then(() => {
            this.reset(this.post.id);
          });
        } else {
          this.$post.create(this.post).then(() => {
            this.reset();
          });
        }
      }
    },
    reset(type = "") {
      this.$router.push("/" + this.$route.params.type + "/" + type);
      /* this.post = {
        name: "",
        content: "",
        type_id: this.type.id
      }; */
    }
  }
};
</script>
