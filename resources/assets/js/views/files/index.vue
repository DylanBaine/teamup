<template>
    <v-container fluid grid-list-xl>
        <router-view></router-view>
        <header>
            <v-form @submit.prevent="executeSearch">
                <v-layout row wrap>
                    <v-flex md2>
                        <h1>
                            Files
                        </h1>
                    </v-flex>
                    <v-flex md5>
                        <v-text-field label="Search Files"
                            clearable
                            flat solo-inverted v-model="search"
                            prepend-icon="search">
                        </v-text-field>
                    </v-flex>
                    <v-slide-x-transition>
                        <v-flex v-show="search">
                            <v-btn color="primary" type="submit">Search</v-btn>
                        </v-flex>
                    </v-slide-x-transition>
                </v-layout>
            </v-form>
            <nav style="width: 90%; margin: auto;">
                <v-btn to="/files" flat>All Files</v-btn>
                <v-btn :to="`/file-type/${type.slug}`" flat v-for="type in types" :key="type.id">{{type.name}}</v-btn>
            </nav>
        </header>
        <v-container v-if="!hasSearched">
            <v-layout row wrap v-if="$route.meta.viewingType">
                <v-flex md3 v-for="file in files" :key="file.id">
                    <v-card>
                        <v-img aspect-ratio="1.2" v-if="file.type.name == 'Image'" :src="file.slug"></v-img>
                        <v-card-text>
                            <h2 class="title">
                                {{file.name}}
                            </h2>
                            <p class="subheading" v-if="file.type">
                                {{file.type.name}}
                            </p>
                            <div style="max-height: 100px; overflow: hidden;">
                                <code style="width: 100%;" v-if="file.file_contents">
                                    {{file.file_contents}}
                                </code>
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="error" @click="deleteFile(file.id)">
                                Delete
                            </v-btn>
                            <v-btn color="primary" :to="`/files/${file.id}`">
                                View
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
            <div v-else>
                <v-layout row wrap v-for="type in files" :key="type.id">
                    <v-flex md12>
                        <h2>
                            {{type.name}}
                        </h2>
                    </v-flex>
                    <v-flex md3 v-for="file in type.files" :key="file.id">
                        <v-card>   
                            <v-img aspect-ratio="1.2" v-if="file.type.name == 'Image'" :src="file.slug"></v-img>
                            <v-card-text>
                                <h2 class="title">
                                    {{file.name}}
                                </h2>
                                <p class="subheading" v-if="file.type">
                                    {{file.type.name}}
                                </p>
                                <div style="max-height: 100px; overflow: hidden;">
                                    <code style="width: 100%;" v-if="file.file_contents">
                                        {{file.file_contents}}
                                    </code>
                                </div>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="error" @click="deleteFile(file.id)">
                                    Delete
                                </v-btn>
                                <v-btn color="primary" :to="`/files/${file.id}`">
                                    View
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </div>
        </v-container>
        <v-container v-else>
            <v-alert :value="!searchResults.length" type="error">
                Sorry... No results for "<i>{{this.search}}</i>".
            </v-alert>
            <v-layout row wrap>
                <v-flex md3 v-for="file in searchResults" :key="file.id">
                    <v-card>
                        <v-img aspect-ratio="1.2" v-if="file.type.name == 'Image'" :src="file.slug"></v-img>
                        <v-card-text>
                            <h2 class="title">
                                {{file.name}}
                            </h2>
                            <p class="subheading" v-if="file.type">
                                {{file.type.name}}
                            </p>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="error" @click="deleteFile(file.id)">
                                Delete
                            </v-btn>
                            <v-btn color="primary" :to="`/files/${file.id}`">
                                View
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <div class="fixed bottom right">
            <v-btn
                :to="$route.params.type ? `/file-type/${$route.params.type}/create`:'/files/create'"
                v-if="$root.$user.can('manage', 'files') || $root.$user.can('create', 'files')"
                fab color="accent">
                <v-icon>add</v-icon>
            </v-btn>
        </div>
    </v-container>
</template>

<script>
import File from "../../app/models/File";
export default {
  data() {
    return {
      search: null,
      files: [],
      types: [],
      searchResults: [],
      hasSearched: false
    };
  },
  watch: {
    search() {
      if (this.search == null || this.search == "") {
        this.hasSearched = false;
        this.searchResults = [];
      }
    }
  },
  computed: {
    $files() {
      return new File(this, "files");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      if (this.$route.meta.controller) {
        this.$root.getPage().then(() => {
          let p = this.$root.page;
          this.files = p.files;
          this.types = p.types;
        });
      }
    },
    deleteFile(fileId) {
      this.$files.delete(fileId, this.init);
    },
    executeSearch() {
      axios.get("/files?search=" + this.search).then(res => {
        this.hasSearched = true;
        this.searchResults = res.data;
      });
    }
  }
};
</script>

