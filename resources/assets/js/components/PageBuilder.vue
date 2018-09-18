<template>
<div>
    <v-card flat>
        <v-card-title>
            <h2 class="title">
                {{label}}
            </h2>
        </v-card-title>
        <v-card-text class="white black--text">
            <!-- <mce @input="change" v-model="value" :init="init"></mce> -->
            <editor @input="change" v-model="value" :options="editorOption"></editor>
        </v-card-text>
    </v-card>
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
      /*       init: {
        height: this.height,
        content_css: ["/css/app.css"],
        content_style:
          "body{padding: 20px;} .container{border: dotted 1px blue;} .row{border: dotted 1px grey;}.md4, .x6{border: dotted 1px red;} .jumbotron{border: dotted 1px lightblue;}",
        theme: "modern",
        image_dimensions: false,
        paste_data_images: true,
        body_id: "app",
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1:
          "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        file_picker_callback: function(callback, value, meta) {
          if (meta.filetype == "image") {
            $("#upload").trigger("click");
            $("#upload").on("change", function() {
              var file = this.files[0];
              var reader = new FileReader();
              reader.onload = function(e) {
                callback(e.target.result, {
                  alt: ""
                });
              };
              reader.readAsDataURL(file);
            });
          }
        },
        templates: [
          {
            title: "Two Columns",
            content:
              '<br><div class="container grid-list-md"><div class="layout row wrap"><div class="xs6 flex display-flex align-center justify-center"><div><h2>Heading</h2><p>Text</p></div></div><div class="xs6 flex display-flex align-center justify-center"><div><h2>Heading</h2><p>Text</p></div></div></div><br></div><br>'
          },
          {
            title: "Three Column",
            content:
              '<div class="container grid-list-md"><div class="layout row wrap"><div class="md4 flex display-flex align-center justify-center"><div><h2>Heading</h2><p>Text</p></div></div><div class="md4 flex display-flex align-center justify-center"><div><h2>Heading</h2><p>Text</p></div></div><div class="md4 flex display-flex align-center justify-center"><div><h2>Heading</h2><p>Text</p></div></div></div></div>'
          },
          {
            title: "Card",
            content:
              '<div class="card" style="min-height: 300px;"><div><img src="https://placeimg.com/300/190/arch"/></div><div class="padded"><h1>Card Title</h1><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo accusamus ducimus temporibus aliquid nisi laborum necessitatibus, atque, numquam facilis ea autem maiores reprehenderit porro, magnam eligendi a, quae eaque voluptas.</p></div></div>'
          },
          {
            title: "Button",
            content: '<a href="#" class="btn btn--large padded">Button!</a>'
          },
          {
            title: "Header",
            content:
              '<div class="relative header-from-builder"><div class="absolute align-center justify-center d-flex" style="left: 0; top: 5%; height: 90%; z-index: 9; width: 100%; margin: auto;"><div style="width: 500px; padding: 20px;"><h2>Title</h2><p>Text</p></div></div><img class="absolute" style="z-index: 1;" src="https://placeimg.com/1000/280/arch" /></div><p></p>'
          },
          {
            title: "Contact Form",
            content:
              '<form method="post" action="/contact">@csrf<div><label for="email">Email</label><input type="text" id="email" name="email" class="custom"></div><div><label for="message">Message</label><textarea class="custom" name="message" id="message" rows="20"></textarea></div><button class="btn block" type="submit">Send</button></form>'
          }
        ]
      } */
    };
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
      this.newValue = this.value;
      this.$emit("input", this.newValue);
    }
  }
};
</script>

<style>
.mce-notification-warning {
  display: none !important;
}
</style>