<template>
    <div>
        <GChart
            v-if="data"
            :type="type"
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
        chartArea: {
          height: "94%",
          width: this.width
        }
      }
    };
  },
  mounted() {
    console.log(this.$vuetify.theme);
  },
  props: ["data", "type", "width"]
};
</script>

