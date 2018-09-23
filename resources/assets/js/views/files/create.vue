<template>
    <v-dialog v-model="showing">
        <v-card>
            <v-card-title class="primary white--text">
                <h2 class="title">
                    Add a file
                </h2>
                <v-spacer></v-spacer>
                <v-btn to="/files" flat icon>
                    <v-icon>close</v-icon>
                </v-btn>
            </v-card-title>
            <v-form ref="form" @submit.prevent="post">
                <v-card-text>
                        <v-layout row wrap align-center>
                            <v-flex offset-md3 md3 class="text-xs-right padded">
                              <div class="text-xs-center">
                                <input type="file" id="image" @change="onFileChange">
                                <br>
                                <br>
                                <v-chip class="error white--text" v-if="file_error">{{file_error}}</v-chip>
                              </div>
                            </v-flex>
                            <v-flex md4>
                                <v-text-field label="File Name" v-model="file.name" :rules="[(v) => v.length < 100 && v.length > 1 || 'This field is required']"></v-text-field>
                            </v-flex>
                        </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn type="submit" color="primary">Save</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import File from "../../app/models/File";
export default {
  data() {
    return {
      file: {
        name: "",
        file: null
      },
      image: null,
      showing: false,
      file_error: null,
      maxFileSize: 640000, // in bytes
      fileTooBigText: "I'm sorry. This file is too large to process."
    };
  },
  computed: {
    $file() {
      return new File(this, "file");
    }
  },
  mounted() {
    this.showing = true;
  },
  methods: {
    post() {
      var config = {
        headers: { "Content-Type": "multipart/FormData" }
      };
      let data = new FormData();
      let file = document.getElementById("image").files[0];
      data.append("file", file);
      data.append("file_name", this.file.name);
      if (this.validated()) {
        this.$file.create(data, config).then(() => {
          if (this.$route.params.type) {
            this.$router.push("/file-type/" + this.$route.params.type);
          } else {
            this.$router.push("/files");
          }
        });
      }
    },
    validated() {
      let file = this.file.file;
      if (file && file.size > this.maxFileSize) {
        this.file_error = this.fileTooBigText;
      } else {
        return this.$refs.form.validate();
      }
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
      let file = document.getElementById("image").files[0];
      if (file.size > this.maxFileSize) {
        this.file_error = this.fileTooBigText;
      } else {
        this.file_error = null;
      }
      this.file.name = file.name.split(".")[0];
      this.file.file = file;
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  }
};
</script>

