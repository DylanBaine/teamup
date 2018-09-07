<template>
    <div>
        <GChart
            v-if="data"
            type="PieChart"
            :data="data"
            :options="options"
        />
    </div>
</template>

<script>
export default {
  data() {
    return {
      theme: this.$vuetify.them,
      options: {
        colors: ["#014841", "#11756c", "#26a69a", "#7cc3bd", "#b6e2de"],
        backgroundColor: {
          fill: "transparent"
        },
        legend: {
          textStyle: {
            color: "white"
          }
        }
      }
    };
  },
  mounted() {
    console.log(this.$vuetify.theme);
  },
  props: ["data"]
};
</script>

