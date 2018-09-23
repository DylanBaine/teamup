<template>
<div>
    <v-card flat>
        <v-card-title>
            <h2 class="title">
                {{label}}
            </h2>
            <v-spacer></v-spacer>
            <v-btn @click="fullscreen = !fullscreen" flat icon>
              <v-icon>{{fullscreen ? 'fullscreen_exit' : 'fullscreen'}}</v-icon>
            </v-btn>
        </v-card-title>
        <v-card-text class="white black--text" style="max-height: 400px; overflow: auto;">
            <!-- <mce @input="change" v-model="value" :init="init"></mce> -->
            <editor v-if="!fullscreen" v-model="newValue" :options="editorOption"></editor>
        </v-card-text>
    </v-card>
    <v-dialog v-model="fullscreen" fullscreen transition="slide-x-reverse-transition">
      <v-card flat class="white black--text">
            <v-icon @click="fullscreen = false" class="fixed top right padded" color="black">fullscreen_exit</v-icon>
              <!-- <mce @input="change" v-model="value" :init="init"></mce> -->
              <editor v-if="fullscreen" style="height: 90vh;" v-model="newValue" :options="editorOption"></editor>
      </v-card>     
    </v-dialog>
</div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue";
// require styles
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";

import { quillEditor } from "vue-quill-editor";
export default {
  data() {
    return {
      fullscreen: false,
      editorOption: {
        modules: {
          toolbar: [
            [{ size: ["small", false, "large"] }],
            ["bold", "italic"],
            [{ align: ["center", "right", false] }],
            [{ list: "ordered" }, { list: "bullet" }],
            ["link"]
          ],
          history: {
            delay: 1000,
            maxStack: 50,
            userOnly: false
          }
        }
      },
      newValue: ""
    };
  },
  watch: {
    value() {
      this.newValue = this.value;
    },
    newValue() {
      this.change();
    }
  },
  components: {
    mce: Editor,
    editor: quillEditor
  },
  computed: {},
  props: ["value", "label", "height"],
  mounted() {},
  methods: {
    change() {
      this.$emit("input", this.newValue);
    }
  }
};
</script>

<style>
.mce-notification-warning {
  display: none !important;
}
.builder-fullscreen {
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
}
</style>