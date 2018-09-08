<template>
    <v-dialog v-model="showing" :width="500" persistent>
        <v-card>
            <v-toolbar color="primary" dark>
                <h2 class="title">
                    Create Post Types
                </h2>
                <v-spacer></v-spacer>
                <v-btn flat icon @click="showing = false">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-form @submit.prevent="createType">
                <v-card-text>
                        <v-text-field
                            label="Type Name"
                            v-model="newType.name"
                        ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" type="submit" block>
                        Save
                    </v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import Type from "../../app/models/PostType";
export default {
  data() {
    return {
      showing: false,
      newType: {
        name
      }
    };
  },
  mounted() {
    //this.init();
  },
  computed: {
    $type() {
      return new Type(this.$parent, "types");
    }
  },
  methods: {
    init() {
      this.showing = true;
    },
    createType() {
      this.$type.create(this.newType).then(() => {
        this.newType = {
          name: ""
        };
      });
    }
  }
};
</script>
