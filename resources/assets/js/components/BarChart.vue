<template>
    <div>
        <GChart
            v-if="data"
            type="ColumnChart"
            :data="data"
            :options="options"
        />
    </div>
</template>

<script>
export default {
  data() {
    return {
      theme: this.$vuetify.theme
    };
  },
  mounted() {
    console.log(this.$vuetify.theme);
  },
  props: ["data"]
};
</script>

