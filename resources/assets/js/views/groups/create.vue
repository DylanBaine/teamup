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
                    Create a new group.
                </h2>
            </v-card-title>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      showing: false,
      group: {}
    };
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