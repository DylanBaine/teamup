<template>
    <v-dialog v-model="showing" persistent>
        <v-card>
          <v-toolbar dark color="primary">
              <v-btn icon :to="$route.params.task ? `/tasks/${$route.params.task}/manage` : '/tasks/'">
                  <v-icon>chevron_left</v-icon>
              </v-btn>
              <h2 class="title">
              </h2>
          </v-toolbar>
          <v-container grid-list-xl>
            <v-form @submit.prevent="post()">
              <v-card-text>
                <v-layout row wrap justify-center>
                  <v-flex md8>
                    <v-text-field
                      label="Name"
                      v-model="task.name"
                    ></v-text-field>
                  </v-flex>
                </v-layout>
                <v-layout row wrap justify-center>
                  <v-flex md4>
                    <v-select
                      label="User To Assign"
                    ></v-select>
                  </v-flex>
                  <v-flex md4>
                    <v-select
                      v-model="task.type_id"
                      label="Type"
                      :items="types"
                      item-text="name"
                      item-value="id"
                    ></v-select>
                  </v-flex>
                  <v-flex md4 v-if="editing || !$route.params.task">
                    <v-select
                      v-model="task.parent_id"
                      label="Parent Task"
                      :items="parentOptions"
                      item-text="name"
                      item-value="id"
                    ></v-select>
                  </v-flex>
                </v-layout>
                <v-layout row wrap align-center>
                  <v-flex md6>
                  <icon-selector
                    label="Select an icon"
                    v-model="task.icon"
                  ></icon-selector>
                  </v-flex>
                  <v-flex md6>
                    <v-text-field
                      multi-line
                      label="Description"
                      v-model="task.description"
                    ></v-text-field>                    
                    <v-btn block color="success" type="submit">
                      Save
                    </v-btn>
                  </v-flex>
                </v-layout>
              </v-card-text>
            </v-form>
          </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
import TaskType from "../../app/Models/TaskType";
import Task from "../../app/models/Task";
export default {
  data() {
    return {
      showing: false,
      task: {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        type_id: null,
        name: null,
        description: null
      },
      editing: this.$route.meta.editing,
      types: [],
      parentOptions: []
    };
  },
  computed: {
    $types() {
      return new TaskType(this, "types");
    },
    $tasks() {
      return new Task(this, "parentOptions");
    }
  },
  mounted() {
    this.init();
    console.log(this.$parent);
  },
  methods: {
    init() {
      if (this.editing) {
        this.task = this.$parent.task;
      }
      this.$tasks.get();
      this.$types.get().then(res => {
        this.showing = true;
      });
    },
    post() {
      if (this.editing) {
        this.update();
      } else {
        this.save();
      }
    },
    update() {
      var t = this.task;
      var data = {
        name: t.name,
        description: t.description,
        user_id: t.user_id,
        type_id: t.type_id,
        icon: t.icon,
        parent_id: t.parent_id
      };
      this.$tasks.update(this.task.id, data).then(res => {
        this.$parent.init();
      });
    },
    save() {
      this.$tasks.create(this.task).then(res => {
        this.reset();
        this.$parent.init();
      });
    },
    reset() {
      this.task = {
        icon: null,
        parent_id: this.$route.params.task ? this.$route.params.task : null,
        user_id: null,
        type_id: null,
        name: null,
        description: null
      };
    }
  }
};
</script>