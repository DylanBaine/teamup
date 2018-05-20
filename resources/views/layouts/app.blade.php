<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
    const url = "{{ url('') }}";
    </script>
</head>
<body>
    <div id="app" v-cloak>
        <v-app id="inspire">
            <v-navigation-drawer
                v-if="AuthUser.email != null"
                :clipped="$vuetify.breakpoint.lgAndUp"
                v-model="drawer"
                fixed
                app
            >                                                                                                                       
                <v-list dense>  
                    <template v-for="item in items">
                        <v-layout
                        v-if="item.heading"
                        :key="item.heading"
                        row
                        align-center
                        >
                            <v-flex xs6>
                                <v-subheader v-if="item.heading">
                                @{{ item.heading }}
                                </v-subheader>
                            </v-flex>
                            <v-flex xs6 class="text-xs-center">
                                <a href="#!" class="body-2 black--text">EDIT</a>
                            </v-flex>
                        </v-layout>
                        <v-list-group
                        v-else-if="item.children"
                        v-model="item.model"
                        :key="item.text"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        >
                            <v-list-tile slot="activator">
                                <v-list-tile-content>
                                <v-list-tile-title>
                                    @{{ item.text }}
                                </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile
                                v-for="(child, i) in item.children"
                                :key="i"
                                to="foo"
                            >
                                <v-list-tile-action v-if="child.icon">
                                <v-icon>@{{ child.icon }}</v-icon>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                <v-list-tile-title>
                                    @{{ child.text }}
                                </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list-group>
                        <v-list-tile v-else :key="item.text" @click="">
                            <v-list-tile-action>
                                <v-icon>@{{ item.icon }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                @{{ item.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </template>
                </v-list>
            </v-navigation-drawer>
            <v-toolbar
                v-if="AuthUser.email != null"
                :clipped-left="$vuetify.breakpoint.lgAndUp"
                color="primary"
                dark
                app
                fixed
            >
                <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
                    <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                    <span class="hidden-sm-and-down">@{{AuthUser.name}}</span>
                </v-toolbar-title>
                <v-text-field
                    flat
                    solo-inverted
                    prepend-icon="search"
                    label="Search"
                    class="hidden-sm-and-down"
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-btn icon @click="user.logout()">
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
                    <v-layout justify-center align-center>
                        <router-view></router-view>
                    </v-layout>
                </v-container>
            </v-content>
            <v-btn
                v-if="AuthUser.email != null"
                fab
                bottom
                right
                color="pink"
                dark
                fixed
                @click.stop="dialog = !dialog"
            >
                <v-icon>add</v-icon>
            </v-btn>
            <v-dialog v-model="dialog" width="800px">
                <v-card>
                <v-card-title
                    class="grey lighten-4 py-4 title"
                >
                    Create contact
                </v-card-title>
                <v-container grid-list-sm class="pa-4">
                    <v-layout row wrap>
                    <v-flex xs12 align-center justify-space-between>
                        <v-layout align-center>
                        <v-avatar size="40px" class="mr-3">
                            <img
                            src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                            alt=""
                            >
                        </v-avatar>
                        <v-text-field
                            placeholder="Name"
                        ></v-text-field>
                        </v-layout>
                    </v-flex>
                    <v-flex xs6>
                        <v-text-field
                        prepend-icon="business"
                        placeholder="Company"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs6>
                        <v-text-field
                        placeholder="Job title"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                        prepend-icon="mail"
                        placeholder="Email"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                        type="tel"
                        prepend-icon="phone"
                        placeholder="(000) 000 - 0000"
                        mask="phone"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                        prepend-icon="notes"
                        placeholder="Notes"
                        ></v-text-field>
                    </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <v-btn flat color="primary">More</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
                    <v-btn flat @click="dialog = false">Save</v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>
        </v-app>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
