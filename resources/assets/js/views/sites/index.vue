<template>
  <v-container grid-list-lg>
    <router-view></router-view>
    <h1>
      Sites
    </h1>
    <v-layout row wrap>
      <v-flex md6 v-for="site in sites" :key="site.key">
        <v-card ripple :to="`/sites/${site.subroute}`">
          <v-card-title class="grey lighten-2">
            <h2 class="title black--text">
              {{site.name}}
            </h2>
          </v-card-title>
        </v-card>
      </v-flex>
    </v-layout>
          <v-slide-x-transition>
            <v-btn
              v-if="!fam"
              color="primary"
              outline
              fab
              class="fixed bottom right"
              @click="fam = !fam">
              <v-icon>more_vert</v-icon>  
            </v-btn>
          </v-slide-x-transition>
          <v-slide-x-reverse-transition>
            <div class="fixed bottom right" v-if="fam">
                <v-btn v-if="$user.can('create', 'sites')"
                    fab
                    color="accent"
                    dark
                    :to="`/sites/create`">
                    <v-icon>add</v-icon>
                </v-btn>
                <v-btn
                    fab
                    color="primary"
                    outline
                    @click="fam = !fam">
                    <v-icon>chevron_right</v-icon>
                </v-btn>
            </div>
          </v-slide-x-reverse-transition>
  </v-container>
</template>

<script>
import Site from "../../app/models/Site";
import User from "../../app/models/User";
export default {
  data() {
    return {
      fam: false,
      sites: []
    };
  },
  computed: {
    $sites() {
      return new Site(this, "sites");
    },
    $user() {
      return new User(this.$root, "user");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$sites.get();
    }
  }
};
</script>