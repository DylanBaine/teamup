<template>
	<v-app :dark="dark" id="inspire">
		<v-navigation-drawer
			:clipped="$vuetify.breakpoint.lgAndUp"
			v-model="drawer"
			fixed
			app>
			<v-list style="padding: 0;">
				<v-toolbar dark color="primary darken-1">
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
				<template v-for="permission in $user.permissions('read')">
					<v-list-tile
						:to="`/${permission.type.slug}`"
						:key="permission.key">
						<v-list-tile-action>
							<v-icon size="15px">{{permission.type.icon}}</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>
								{{ permission.type.name }}
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</template>
			</v-list>
		</v-navigation-drawer>
		<v-toolbar
			:clipped-left="$vuetify.breakpoint.lgAndUp"
			color="primary"
			dark
			app
			fixed>
			<v-toolbar-title style="width: 300px" class="ml-0 pl-3">
				<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
				<span class="hidden-sm-and-down">{{$root.company.name}}</span>
			</v-toolbar-title>
			<v-text-field
				flat
				solo-inverted
				prepend-icon="search"
				label="Search"
				class="hidden-sm-and-down"
			></v-text-field>
			<v-spacer></v-spacer>
			<v-btn icon @click="dark = !dark">
				<v-icon>highlight</v-icon>
			</v-btn>
			<v-btn icon @click="$user.logout()">
				<v-icon>close</v-icon>
			</v-btn>
		</v-toolbar>
		<v-content>
			<v-container fluid fill-height>
				<v-layout>
					<router-view :key="$route.fullPath"></router-view>
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
	</v-app>
</template>

<script>
import User from "./../app/models/User";
export default {
  data() {
    return {
      dialog: false,
      drawer: true,
      dark: true,
      showCreateModal: false
    };
  },
  mounted() {
    var thing = this.$user.permissions("create");
    console.log(thing);
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
    }
  }
};
</script>