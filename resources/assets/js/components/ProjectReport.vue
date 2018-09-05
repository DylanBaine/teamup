<template>
    <div>
        <GChart
            v-if="report"
            type="PieChart"
            :data="report.task_breakdown"
        />
    </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  props: ["report"]
};
</script>