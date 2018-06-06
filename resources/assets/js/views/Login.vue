<template>
  <div>
    <div v-if="$root.user">
      <h1>Welcome Back, {{user.name}}!</h1>
      <v-btn to="/">Go Home</v-btn>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$root.user = false;
  }
};
</script>