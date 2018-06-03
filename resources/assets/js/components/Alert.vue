<template>
<div class="fixed top left" style="z-index:900;">
    <div class="alert-container">
        <v-snackbar
            v-for="(alert, i) in alerts"
            :key="i"
            :class="`white--text`"
            :color="alert.type"
            :value="alert.showing"
            top
            :timeout="alert.to !== null ? 7000 : 3500">
            <div class="inner">
                <v-icon class="mr-3" color="white">{{alert.type}}</v-icon>
                <h4 class="subheading">{{alert.message.length >= 100 ? alert.message.substr(0, 150) + '...' : alert.message}}</h4>
                <v-btn v-if="alert.to !== null" :to="alert.to" small flat color="white">See More</v-btn>
            </div>
        </v-snackbar>
    </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      alerts: [],
      count: 0
    };
  },
  watch: {},
  methods: {
    run(message, type, to = null) {
      this.count++;
      this.alerts.push({
        message: message,
        showing: true,
        type: type,
        to: to
      });
    }
  }
};
</script>

<style scoped>
.alert-container {
  padding-top: 10px;
  max-height: 200px;
  overflow: hidden;
}
.inner {
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.2);
  text-align: center;
  display: inline-flex;
  align-items: center;
  padding: 10px;
}
</style>

