<template>
    <div>
        <pie-chart
            :data="report.task_breakdown"        
        ></pie-chart>
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