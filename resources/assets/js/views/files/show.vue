<template>
    <v-dialog v-model="showing" :fullscreen="needsFullscreen" :width="600">
      <a :href="file.slug" :download="file.name" ref="downloadLink"></a>
      <div class="grey darken-4" v-if="file.type && file.type.name == 'Image'">
        <v-img :src="file.slug" contain :width="600" max-height="70vh"></v-img>
        <v-card-text>
          <v-btn flat color="error" @click="showing = false">Cancel</v-btn>
          <v-btn color="primary" :href="file.slug" :download="file.name">
            <v-icon class="mr-1">cloud_download</v-icon> download
          </v-btn>
        </v-card-text>
      </div>
      <v-card v-else-if="file.type && file.type.name == 'Word Document' || file.type && file.type.name == 'Excel Sheet'">
        <v-card-title>
          <h2 class="title">
            {{file.name}}
          </h2>
          <v-spacer></v-spacer>
          <v-tooltip bottom class="mr-1">
            <v-icon @click="$refs.downloadLink.click()" slot="activator" color="primary">cloud_download</v-icon>
            <span>Download</span>
          </v-tooltip>
          <v-tooltip bottom class="mr-1">
            <v-icon slot="activator" @click="showing = false">close</v-icon>
            <span>Exit</span>
          </v-tooltip>
        </v-card-title>
        <v-card-text style="min-height: 70vh;">
          <iframe  width="100%" style="height: 90vh;" :src="`https://view.officeapps.live.com/op/embed.aspx?src=${file.slug}`"></iframe>
        </v-card-text>
      </v-card>
      <v-card v-else>
        <v-card-title>
          <h2 class="title">
            {{file.name}}
          </h2>
          <v-spacer></v-spacer>
          <v-tooltip bottom class="mr-1">
            <v-icon @click="$refs.downloadLink.click()" slot="activator" color="primary">cloud_download</v-icon>
            <span>Download</span>
          </v-tooltip>
          <v-tooltip bottom class="mr-1">
            <v-icon slot="activator" @click="needsFullscreen = !needsFullscreen">{{needsFullscreen ? 'fullscreen_exit':'fullscreen'}}</v-icon>
            <span>{{needsFullscreen ? 'Exit Fullscreen' : 'View Fullscreen'}}</span>
          </v-tooltip>
          <v-tooltip bottom class="mr-1">
            <v-icon slot="activator" @click="showing = false">close</v-icon>
            <span>Exit</span>
          </v-tooltip>
        </v-card-title>
        <header class="padded" v-if="file.type">
          {{file.type.name}}
          <h3 v-if="file.file_contents">File Content:</h3>
          <v-btn v-if="file.file_contents && file.file_contents.isHTML()" small @click="renderHTML = ! renderHTML">{{renderHTML ? 'Render as normal text' : 'Render HTML'}}</v-btn>
        </header>
        <v-card-text :style="style">
          <div class="mb-5" v-if="file.file_contents">
            <v-container v-if="renderHTML" v-html="file.file_contents"></v-container>
            <code v-else style="width: 100%;" class="padded">{{file.file_contents}}</code>
          </div>
          <div v-else>
            No preview available for this file type.
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
</template>

<script>
export default {
  data() {
    return {
      renderHTML: false,
      file: {
        type: null
      },
      showing: false,
      needsFullscreen: false,
      embedded: false
    };
  },
  props: ["asModal"],
  watch: {
    showing() {
      if (!this.showing) {
        if (!this.embedded)
          this.$router.push("/file-type/" + this.file.type.slug);
      }
    }
  },
  computed: {
    style() {
      let height = this.needsFullscreen ? "80vh" : "400px";
      return `max-height: ${height}; overflow: auto;`;
    }
  },
  mounted() {
    if (!this.$root.mounted && !this.asModal) this.init();
    console.log("Init");
  },
  methods: {
    init() {
      this.$root.getPage().then(() => {
        this.$root.mounted = true;
        let p = this.$root.page;
        this.file = p;
        this.showing = true;
        this.setFullscreen();
      });
    },
    setFullscreen() {
      let type = this.file.type ? this.file.type.name : null;
      if (type == "Word Document" || type == "Excel Sheet")
        return (this.needsFullscreen = true);
      this.needsFullscreen = false;
    },
    embed(fileId) {
      this.embedded = true;
      axios.get(`${url}/files/${fileId}`).then(res => {
        this.file = res.data;
        this.showing = true;
      });
    }
  }
};
</script>

