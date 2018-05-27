<template>
	<v-fade-transition>
		<div id="container" v-if="showing">
			<div id="loader">
				<v-progress-circular :size="50" indeterminate color="primary"></v-progress-circular>
				<h2 class="title">{{message}}</h2>
			</div>
		</div>
	</v-fade-transition>
</template>

<script>
export default {
  data() {
    return {
      showing: false,
      message: ""
    };
  },
  methods: {
    run(message = "") {
      this.showing = !this.showing;
      this.message = message;
    }
  }
};
</script>

<style>
#container {
  z-index: 999;
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(255, 255, 255, 0.3);
}
#loader {
  position: fixed;
  width: 200px;
  bottom: 0;
  left: 0;
  text-align: center;
}
</style>

