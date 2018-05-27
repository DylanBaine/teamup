<template>
	<v-app id="inspire">
		<v-navigation-drawer
			:clipped="$vuetify.breakpoint.lgAndUp"
			v-model="drawer"
			fixed
			app>
			<v-list dense>
				<template v-for="permission in $user.permissions('read')">
					<v-list-tile
						:to="`/${type.slug}`"
						v-for="type in permission.types"
						:key="type.id">
						<v-list-tile-action>
							<v-icon size="15px">chrome_reader_mode</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>
								{{ type.name }}
							</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</template>
				<v-list-group>
					<v-list-tile slot="activator">
						<v-list-tile-action>
							<v-icon>group</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							Groups
						</v-list-tile-content>
					</v-list-tile>
					<v-list-tile v-for="group in user.groups" :key="group.id" :to="`/groups/${group.id}`">
						<v-list-tile-action>
							<v-icon>group</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							{{group.name}}
						</v-list-tile-content>
					</v-list-tile>
					<v-list-tile to="/groups/">
						<v-list-tile-action>
							<v-icon>remove_red_eye</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							All Groups
						</v-list-tile-content>
					</v-list-tile>
					<v-list-tile v-if="$user.can('create', 'groups')" to="/groups/create">
						<v-list-tile-action>
							<v-icon>add</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							Create Group
						</v-list-tile-content>
					</v-list-tile>
				</v-list-group>
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
			<v-btn icon @click="$user.logout()">
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
		</v-toolbar>
		<v-content>
			<v-container fluid fill-height>
				<v-layout>
					<router-view></router-view>
				</v-layout>
			</v-container>
		</v-content>
		<v-btn
			fab
			bottom
			right
			color="pink"
			dark
			fixed
			@click.stop="dialog = !dialog">
			<v-icon>add</v-icon>
		</v-btn>
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
      drawer: true
    };
  },
  mounted() {},
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