<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon to="/groups/">
                    <v-icon>chevron_left</v-icon>
                </v-btn>
                <h2 class="title">
                    {{group.name}}
                </h2>
            </v-toolbar>
            <v-card-text>
              <v-list>
                <v-list-tile v-for="user in group.users" :key="user.key" :to="`/users/${user.id}`">
                  <v-list-tile-content>
                    {{user.name}}
                  </v-list-tile-content>
                </v-list-tile>
              </v-list>
            </v-card-text>
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
      this.$group.find(this.$route.params.group);
    }
  }
};
</script>
