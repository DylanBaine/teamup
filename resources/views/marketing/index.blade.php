@extends('layouts.marketing')

@section('content')
    <v-content>
      <!-- <section id="header" v-if="$vuetify.breakpoint.lgAndUp">
        <v-parallax src="{{url('/images/task_view.png')}}" height="800">
          <v-layout
            class="white--text"
            column align-center
            justify-center>
            <h1 class="mb-2 display-1 text-xs-center">Timatik</h1>
            <div class="subheading mb-3 text-xs-center">Agile software that's agile.</div>
            <v-btn
              class="primary"
              dark large
              href="{{url('/register')}}">
              Get Started
            </v-btn>
          </v-layout>
        </v-parallax>
      </section> -->
      <section id="mobile_header">
          <v-layout
            class="marketing-mobile-header"
            column align-center
            justify-center>
            <div class="image_inner_div">
              <h1 class="mb-2 display-1 text-xs-center">Timatik</h1>
              <div class="subheading mb-3 text-xs-center">Agile software that's agile.</div>
              <v-btn
                class="primary"
                dark large
                href="{{url('/register')}}">
                Get Started
              </v-btn>
            </div>
          </v-layout>
      </section>

      <div id="under_header">
        <section id="more_than">
          <v-container>
            <v-card>
              <v-layout
                column wrap
                class="my-5"
                align-center>
                <v-flex xs12 sm4 class="mt-2">
                  <div class="text-xs-center">
                    <h2 class="headline">More than just project management.</h2>
                  </div>
                </v-flex>
                <v-flex xs12>
                  <v-container fluid grid-list-xl>
                    <v-layout row wrap align-center>
                      <v-flex xs12 md4>
                        <v-card class="elevation-0 transparent">
                          <v-card-text class="text-xs-center">
                            <v-icon x-large class="accent--text text--lighten-2">edit</v-icon>
                          </v-card-text>
                          <v-card-title primary-title class="layout justify-center">
                            <div class="headline text-xs-center">Posts</div>
                          </v-card-title>
                          <v-card-text>
                            Share content organization wide, or just with groups. Create custom post types.
                            Perfect for sharing announcements, documentation, notes, etc...
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex xs12 md4>
                        <v-card class="elevation-0 transparent">
                          <v-card-text class="text-xs-center">
                            <v-icon x-large class="accent--text text--lighten-2">upload_file</v-icon>
                          </v-card-text>
                          <v-card-title primary-title class="layout justify-center">
                            <div class="headline">File Storage</div>
                          </v-card-title>
                          <v-card-text>
                            Upload files to be shared with others in your organization or team. Upload files to tasks or projects.
                            Share (and view) Excell sheets and Word documents with your team.. Share installers.
                          </v-card-text>
                        </v-card>
                      </v-flex>
                      <v-flex xs12 md4>
                        <v-card class="elevation-0 transparent">
                          <v-card-text class="text-xs-center">
                            <v-icon x-large class="accent--text text--lighten-2">show_chart</v-icon>
                          </v-card-text>
                          <v-card-title primary-title class="layout justify-center">
                            <div class="headline text-xs-center">Reporting</div>
                          </v-card-title>
                          <v-card-text>
                            Know who did what when. Keep track of the life-cycle of any task or project.
                            Get the insights you need so you can keep the stake holders in the know.
                          </v-card-text>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-flex>
              </v-layout>
            </v-card>
            </v-container>
        </section>

        <!-- <section id="scalable_adjustable" v-if="$vuetify.breakpoint.lgAndUp">
          <v-parallax src="{{url('/images/task_view.png')}}" height="380">
            <v-layout column align-center justify-center>
              <div class="headline white--text mb-3 text-xs-center">Scalable // Adjustable // Maintainable</div>
              <em>Easy organization between tasks, projects, and teams.</em>
            </v-layout>
          </v-parallax>
        </section> -->
        <section id="mobile_scalable_adjustable">
            <v-layout column align-center justify-center>
              <div class="image_inner_div">
                <div class="headline white--text mb-3 text-xs-center">Scalable Adjustable Maintainable</div>
                <em>Easy organization between tasks, projects, and teams.</em>
              <v-btn
                class="primary"
                dark large
                href="{{url('/register')}}">
                sign up for free
              </v-btn>
              </div>
            </v-layout>
        </section>

        <section id="learn_more">
          <v-container grid-list-xl>
            <v-layout row wrap align-center justify-center>
              <v-flex md4>
                <v-card>
                  <v-card-title class="accent white--text">
                    <h1>Organize your tasks your way.</h1>
                  </v-card-title>
                  <v-card-text>
                    <ul>
                      <li>With Timatik, you can choose how many levels a project or task goes.</li>
                      <li>You decide how many columns a sprint needs.</li>
                    </ul>
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex md4>
                <v-card>
                  <v-card-title class="accent white--text">
                    <h1>Get as many or few notifications as you want.</h1>
                  </v-card-title>
                  <v-card-text>
                    <ul>
                      <li>No more task spam in your inbox.</li>
                      <li>Each user chooses weather or not they are subscribbed to a task.</li>
                    </ul>
                  </v-card-text>
                </v-card>
              </v-flex>
              <v-flex md4>
                <v-card>
                  <v-card-title class="accent white--text">
                    <h1>Easy pricing</h1>
                  </v-card-title>
                  <v-card-text>
                    <ul>
                      <li>Only pay for the users you need.</li>
                      <li>Only pay for the features you want.</li>
                    </ul>
                  </v-card-text>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </section>
      </div>
    </v-content>
@stop