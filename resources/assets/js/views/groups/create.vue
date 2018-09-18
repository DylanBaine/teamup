<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
            <v-toolbar dark color="primary">
                <h2 class="title">
                    Create a new group.
                </h2>
                <v-spacer></v-spacer>
                 <v-btn icon to="/groups/">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
              <v-form @submit.prevent="save">
                <v-container grid-list-lg>
                  <v-layout row wrap>
                    <v-flex offset-md2 md6>
                      <v-text-field
                        label="Name"
                        v-model="group.name"
                      ></v-text-field>
                    </v-flex>
                    <v-flex md2>
                      <v-btn type="submit" block color="primary">
                        Save
                      </v-btn>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      showing: false,
      group: {}
    };
  },
  computed: {
    $group() {
      return new Group(this, "group");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.showing = true;
    },
    reset() {
      this.group = {};
    },
    save() {
      this.$group.create(this.group).then(() => {
        this.reset();
      });
    }
  }
};
</script>