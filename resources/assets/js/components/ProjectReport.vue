<template>
    <div>
        <h2 class="text-xs center tite">
            {{report.label}}
        </h2>
        <v-tabs>
            <v-tab v-for="(layout, key) in report.layouts" :key="key">
                {{layout.name}}
            </v-tab>
            <v-tab-item v-for="(layout, key) in report.layouts" :key="key">
                <v-card class="text-xs-center white" style="padding: 50px;">
                    <generic-chart
                        style="margin: auto;"
                        :type="layout.chart"
                        :data="report.data"
                        width="80%"
                    ></generic-chart>
                </v-card>
            </v-tab-item>
        </v-tabs>
    </div>
</template>

<script>
export default {
  data() {
    return {
      type: null
    };
  },
  mounted() {
    this.type = this.report.layouts[0];
  },
  props: ["report"]
};
</script>