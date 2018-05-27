<template>
    <v-dialog v-model="showing">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon to="/groups/">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-title class="grey lighten-2">
                <h2 class="title">
                    {{group.name}}
                </h2>
            </v-card-title>              
        </v-card>
    </v-dialog>
</template>

<script>
import Group from "../../app/models/Group";
export default {
  data() {
    return {
      group: "",
      showing: false
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
      this.$group.find("id", this.$route.params.group);
    }
  }
};
</script>
