	<template>
	<div>
		<v-navigation-drawer
			:clipped="$vuetify.breakpoint.lgAndUp"
			v-model="drawer"
			fixed
			app>
			<v-list style="padding: 0;">
				<v-toolbar dark color="primary darken-1" style="width: 100%;">
					<v-spacer></v-spacer>
					<v-btn icon to="/">
						<v-icon>home</v-icon>
					</v-btn>
					<v-btn icon @click="$refs.manageModal.init()">
						<v-icon>apps</v-icon>
					</v-btn>
					<v-btn icon>
						<v-icon>notifications</v-icon>
					</v-btn>
					<v-spacer></v-spacer>
				</v-toolbar>
			</v-list>
			<v-list dense>
				<template v-for="(permission, key) in $user.permissions('read')">
					<v-tooltip :color="((key+1) % 2) == 0 ? 'primary' : 'accent'" right :key="key">
						<v-list-tile
							slot="activator"
							:to="`/${permission.type.slug}`">
							<v-list-tile-action>
								<v-icon size="15px">{{permission.type.icon}}</v-icon>
							</v-list-tile-action>
							<v-list-tile-content>
								<v-list-tile-title>
									{{ permission.type.name }}
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
						<span>See all {{permission.type.name}}</span>
					</v-tooltip>
				</template>
			</v-list>
		</v-navigation-drawer>
		<v-toolbar
			class="top-bar"
			:clipped-left="$vuetify.breakpoint.lgAndUp"
			color="primary"
			dark
			app
			fixed>
			<v-toolbar-title style="width: 300px" class="ml-0 pl-3">
				<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
				<span class="hidden-sm-and-down">{{$root.company.name}}</span>
			</v-toolbar-title>
			<v-autocomplete
				clearable
				flat solo-inverted v-model="quickLink"
				prepend-icon="search" label="Search modules"
				:search-input.sync="search" class="hidden-sm-and-down"
				:items="results" @input="quickLink ? $router.push('/'+quickLink.slug) : null"
				item-text="type.name" item-value="type"
			></v-autocomplete>
			<v-spacer></v-spacer>
			<!-- <v-btn icon @click="dark = !dark">
				<v-icon>highlight</v-icon>
			</v-btn> -->
			<v-tooltip left>
				<v-btn slot="activator" flat class="subheading">
					{{user.name}}
				</v-btn>
				<span>Profile</span>
			</v-tooltip>
			<v-tooltip left>
				<v-btn slot="activator" icon @click="$user.logout()">
					<v-icon>exit_to_app</v-icon>
				</v-btn>
				<span>Log Out</span>
			</v-tooltip>
		</v-toolbar>
		<v-content>
			<v-container fluid fill-height>
				<v-layout>
					<router-view :key="randomKey"></router-view>
				</v-layout>
			</v-container>
		</v-content>
		<user-manage-modal ref="manageModal"></user-manage-modal>
		<v-btn
			v-if="$route.params && $user.can('create', $route.params.type)"
			fab
			bottom
			right
			color="pink"
			dark
			fixed
			:to="`/${$route.params.type}/create`">
			<v-icon>add</v-icon>
		</v-btn>
		<loader ref="loader"></loader>
    <alerts ref="alert"></alerts>
		<prompt ref="prompt"></prompt>
	</div>
</template>

<script>
import User from "./../app/models/User";
export default {
  data() {
    return {
      search: null,
      dialog: false,
      drawer: true,
      dark: true,
      results: [],
      randomKey: Math.random(),
      quickLink: null
    };
  },
  watch: {
    $route() {
      this.randomKey = Math.random();
    },
    search(data) {
      this.getSearch(data);
    }
  },
  mounted() {
    var thing = this.$user.permissions("create");
  },
  props: ["user"],
  computed: {
    $user() {
      return new User(this, "user");
    }
  },
  methods: {
    showLoader(message) {
      this.$refs.loader.run(message);
    },
    getSearch(data) {
      axios.get("/toolbar-search?q=" + data).then(res => {
        this.results = res.data;
      });
    }
  }
};
</script>