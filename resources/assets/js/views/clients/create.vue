<template>
    <v-dialog v-model="showing">
        <v-card>
            <v-card-title class="primary white--text">
                <h1 class="title">
                    Add A Client
                </h1>
                <v-spacer></v-spacer>
                <v-btn flat icon color="white" to="/clients">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-card-title>
            <v-form @submit.prevent="post">
                <v-card-text>
                        <v-container grid-list-xl>
                            <v-layout row wrap>
                                <v-flex md4>
                                    <v-text-field label="Client Name" v-model="client.name"></v-text-field>
                                </v-flex>
                                <v-flex md4>
                                    <v-text-field label="Contact Name" v-model="client.contact.name"></v-text-field>
                                </v-flex>
                                <v-flex md4>
                                    <v-text-field label="Contact Email" v-model="client.contact.email"></v-text-field>
                                </v-flex>
                                <v-flex md4 v-for="(field, key) in client.customFields" :key="key">
                                    <v-layout>
                                        <v-text-field
                                            :label="field.name"
                                            v-model="field.value"
                                        ></v-text-field>
                                        <v-icon @click="editField(field)">edit</v-icon>
                                        <v-icon @click="removeField(field)">delete_forever</v-icon>
                                    </v-layout>
                                </v-flex>
                                <v-flex md4>
                                    <v-text-field @keydown.enter.prevent="addCustomField" label="Add Custom Field" v-model="newField.name"></v-text-field>
                                    <v-btn @click="addCustomField" color="primary">Add Field</v-btn>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn type="submit" color="primary">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
import Client from "../../app/models/Client";
export default {
  data() {
    return {
      showing: false,
      newField: {
        name: null
      },
      client: {
        contact: {
          name: null,
          email: null
        },
        customFields: []
      }
    };
  },
  computed: {
    $client() {
      return new Client(this, "client");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$root.getPage().then(() => {});
      this.showing = true;
    },
    editField(original) {
      this.client.customFields.splice(
        this.client.customFields.indexOf(original),
        1
      );
      this.newField = original;
    },
    removeField(field) {
      this.client.customFields.splice(
        this.client.customFields.indexOf(field),
        1
      );
    },
    addCustomField() {
      if (this.newField) {
        this.client.customFields.push(this.newField);
        this.newField = { name: null };
      }
    },
    post() {
      if (this.$route.meta.editing) {
        this.update();
      } else {
        this.create();
      }
    },
    create() {
      let client = this.client;
      let data = {
        name: client.name,
        contact_name: client.contact.name,
        contact_email: client.contact.email,
        custom_fields: JSON.stringify(client.customFields)
      };
      this.$client.create(data);
    }
  }
};
</script>

