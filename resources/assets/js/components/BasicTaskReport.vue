<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex md6>
            <v-card v-if="report.changes.length">
                <v-card-title>
                    <h2 class="title">
                        Log
                    </h2>
                </v-card-title>
                <v-card-text style="height: 400px; overflow: auto;">
                    <v-list>
                        <v-list-tile v-for="change in report.changes" :key="change.id" class="grey darken-2 mb-1" v-if="change.column_id">
                            <v-list-tile-content>
                                Put in to "{{change.column.value}}" about {{change.change_date}} by {{change.user.name}}.
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card-text>
            </v-card>
            </v-flex>
            <v-flex md6>
            <v-card v-if="hasChart">
                <v-card-title>
                    <div>
                        <h2 class="title">
                            Chart
                        </h2>
                        <p class="subheading">
                            Compaired time in columns.
                        </p>
                    </div>
                <v-spacer></v-spacer>
                </v-card-title>
                <v-card-text>
                    <pie-chart
                        :data="report.percent"        
                    ></pie-chart>
                </v-card-text>
            </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>
export default {
  data() {
    return {};
  },
  props: ["report"],
  computed: {
    hasChart() {
      return this.report.percent.length > 1;
    }
  }
};
</script>
