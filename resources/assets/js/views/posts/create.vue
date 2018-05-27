<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
            <v-form>
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
                    ></v-text-field>
                    <h4 class="title">Content</h4>
                    <v-text-field
                        multi-line
                        full-width
                        box
                        rows="15"
                    ></v-text-field>
                    <v-card-actions>
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
export default {
  data() {
    return {
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
    }
  }
};
</script>
