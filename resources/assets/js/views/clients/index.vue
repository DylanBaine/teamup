<template>
    <v-container fluid>
        <router-view></router-view>
        <header>
            <h1>Clients</h1>
        </header>
        <v-container grid-list-xl>
            <v-layout row wrap>
                <v-flex md3 v-for="client in clients" :key="client.id">
                    <v-card :to="`/clients/${client.id}`">
                        <v-card-title class="grey lighten-2 black--text">
                            <h2 class="title">
                                {{client.name}}
                            </h2>
                        </v-card-title>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <div class="fixed bottom right">
            <v-btn to="/clients/create" fab v-if="$root.$user.can('create', 'clients') || $root.$user.can('manage', 'clients')" color="accent">
                <v-icon>add</v-icon>
            </v-btn>
        </div>
    </v-container>
</template>

<script>
export default {
  data() {
    return {
      clients: []
    };
  },
  watch: {
    $route() {
      this.init();
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$root.getPage().then(() => {
        this.clients = this.$root.page;
      });
    }
  }
};
</script>

