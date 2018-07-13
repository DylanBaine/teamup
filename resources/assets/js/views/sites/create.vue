<template>
    <v-dialog
        v-model="showing" 
        persistent
        transition="dialog-transition">
        <v-card>
            <v-toolbar color="primary">
                <v-btn color="white" flat icon to="/sites">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">
                    Create a new site.
                </h2>
            </v-toolbar>
            <v-form @submit.prevent="post">
                <v-card-text>
                    <v-container grid-list-lg>
                        <v-layout row wrap>
                            <v-flex md6>
                                <v-text-field
                                    label="Name"
                                    v-model="site.name"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md6>
                                <v-text-field
                                    label="URL"
                                    v-model="site.url"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn type="submit" color="primary">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import Post from "../../app/models/Post";
import Site from "../../app/models/Site";
export default {
  data() {
    return {
      showing: false,
      posts: [],
      site: {
        name: null,
        url: null
      }
    };
  },
  computed: {
    $posts() {
      return new Post(this, "posts");
    },
    $site() {
      return new Site(this, "site");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.showing = true;
      this.$posts.get();
    },
    post() {
      if (this.$route.meta.editing) {
        this.$site.update(this.site.id, this.site);
      } else {
        this.$site.create(this.site);
      }
    }
  }
};
</script>
