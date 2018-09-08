<template>
    <v-dialog v-model="showing" :width="500">
        <v-card>
            <v-card-text v-html="content"></v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn v-for="button in buttons" :key="button.text" @click="click(button.action)" :color="button.color">
                    {{button.text}}
                </v-btn>
                <v-spacer></v-spacer>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      content: null,
      buttons: [],
      showing: false,
      instance: null
    };
  },
  methods: {
    run(instance, content, buttons) {
      this.instance = instance;
      this.content = content;
      this.buttons = buttons;
      this.showing = true;
    },
    click(func) {
      if (func == "cancel") {
        return (this.showing = false);
      }
      this.instance[func]();
      this.showing = false;
    }
  }
};
</script>

