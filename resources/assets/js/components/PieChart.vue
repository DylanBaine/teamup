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
      theme: this.$vuetify.theme,
      options: {
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

