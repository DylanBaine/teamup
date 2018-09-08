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