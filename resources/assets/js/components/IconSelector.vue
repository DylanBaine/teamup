<template>
<v-card class="text-xs-left">
    <v-card-title>
        <h3>{{label}}</h3>
        <label v-if="selected" class="padded">Selected: <i>{{selected}}</i></label>
    </v-card-title>
    <v-layout row wrap id="icon-input" fluid>
        <v-flex sm3 v-for="category in icons" :key="category.key">
            <v-menu style="width: 100%;" oofset-y>
                <v-btn slot="activator" block flat>
                      <div class="capitalize">{{category.name}}</div>
                </v-btn>
                <v-card style="max-height: 400px; overflow: auto;">
                  <v-card-text class="text-xs-center">
                    <div class="title capitalize">
                      {{category.name}} Icons
                    </div>
                  </v-card-text>
                    <v-list>
                      <v-list-tile v-for="icon in category.icons" :key="icon.key" @click="emitValue(icon.ligature)">
                          <v-list-tile-action>
                              <v-icon style="margin-right: 30px;">{{icon.ligature}}</v-icon>
                          </v-list-tile-action>
                          <v-list-tile-content>
                              {{icon.name}}
                          </v-list-tile-content>
                      </v-list-tile>
                    </v-list>
                </v-card>
            </v-menu>
        </v-flex>
    </v-layout>
</v-card>
</template>

<script>
export default {
  data() {
    return {
      icons: this.$root.icons.categories,
      selected: ""
    };
  },
  props: ["label"],
  methods: {
    emitValue(icon) {
      this.selected = icon;
      this.$emit("input", icon);
    }
  }
};
</script>

<style scoped>
#icon-input {
  height: 300px;
  overflow: auto;
  overflow-x: hidden;
  padding: 0;
  border-radius: 5px;
  width: 100%;
  margin: 0;
}
label {
  padding-left: 10px;
}
</style>

