<template>
    <v-container grid-list-lg>
      <router-view></router-view>
        <header>
            <h1>
                {{site.name}}
            </h1>
        </header>
        <v-tabs color="primary">
          <v-tab v-for="page in site.pages" :key="page.key">
            {{page.name}}
          </v-tab>
          <v-tab-item v-for="page in site.pages" :key="page.key">
            <v-card style="overflow: auto" height="70vh">
              <div v-html="page.content"></div>
              <v-btn v-if="$user.can('update', 'sites')" :to="`/sites/${$route.params.site}/${page.id}`" bottom left color="accent" fab>
                <v-icon>edit</v-icon>
              </v-btn>
            </v-card>
          </v-tab-item>
        </v-tabs>
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
                <v-btn v-if="$user.can('manage', 'sites')"
                    fab
                    color="accent"
                    dark
                    :to="`/sites/${$route.params.site}/create-page`">
                    <v-icon>add</v-icon>
                </v-btn>
                <v-btn v-if="$user.can('update', 'sites')"
                    fab
                    color="info"
                    dark
                    :to="`/sites/${$route.params.site}/settings`">
                    <v-icon>settings</v-icon>
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
      site: null
    };
  },
  computed: {
    $site() {
      return new Site(this, "site");
    },
    $user() {
      return new User(this.$root, "user");
    }
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
      this.$site.find(this.$route.params.site);
    }
  }
};
</script>
