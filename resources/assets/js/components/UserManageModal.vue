<template>
    <v-dialog v-model="showing" width="800px">
        <v-card>
            <v-toolbar class="grey lighten-3 black--text">
                <h2 class="title">Manage:</h2>
                <v-spacer></v-spacer>
                <v-btn @click="showing = false" flat icon color="black">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <v-list>
                    <v-list-tile v-for="permission in permissions.filter(permission=>{return permission.mode.name == 'manage'})" :key="permission.id" :to="`/${permission.type.slug}/manage`">
                        <v-list-tile-content>
                            {{permission.type.name}}
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import Permission from "../app/models/Permission";
export default {
  data() {
    return {
      showing: false,
      permissions: []
    };
  },
  computed: {
    $permissions() {
      return new Permission(this, "permissions");
    }
  },
  methods: {
    init() {
      this.$permissions.get().then(() => {
        this.showing = true;
      });
    }
  }
};
</script>
