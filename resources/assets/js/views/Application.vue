<template>
	<v-app :dark="dark" id="inspire">
		<v-navigation-drawer
			:clipped="$vuetify.breakpoint.lgAndUp"
			v-model="drawer"
			fixed
			app>
			<v-list dense>
				<v-toolbar dark color="primary darken-1">
					<v-spacer></v-spacer>
					<v-btn icon>
						<v-icon>apps</v-icon>
					</v-btn>
					<v-btn icon>
						<v-icon>notifications</v-icon>
					</v-btn>
					<v-btn icon large>
						<v-avatar size="32px" tile>
							<img
							src="https://vuetifyjs.com/static/doc-images/logo.svg"
							alt="Vuetify"
							>
						</v-avatar>
					</v-btn>
					<v-spacer></v-spacer>
				</v-toolbar>
				<template v-for="permission in $user.permissions('read')">
					<v-list-tile
						:to="`/${permission.type.slug}`"
						:key="permission.type.id">
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
				<span class="hidden-sm-and-down">{{user.name}}</span>
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
					<router-view></router-view>
				</v-layout>
			</v-container>
		</v-content>
		<v-dialog v-model="dialog" width="800px">
			<v-card v-for="permission in $user.permissions('create')" :key="permission.id">
				<v-card-text>
					<v-list v-for="type in permission.types" :key="type.id" v-if="type.slug != 'groups'">
						<v-list-tile>
							<v-list-tile-content>
								{{type.name}}
							</v-list-tile-content>
						</v-list-tile>
					</v-list>
				</v-card-text>
			</v-card>
		</v-dialog>
		<loader ref="loader"></loader>
	</v-app>
</template>

<script>
import User from "./../app/models/User";
export default {
  data() {
    return {
      dialog: false,
      drawer: true,
      dark: true
    };
  },
  mounted() {
    var thing = this.$user.can("update", "documentations");
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