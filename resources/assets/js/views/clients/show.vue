<template>
    <v-container v-if="client" fluid grid-list-lg>
        <header>
            <h1>
                {{client.name}}
            </h1>
        </header>
        <v-container>
            <header class="mb-2">
                <h2>
                    Contacts:
                </h2>
            </header>
            <section>
                <v-card v-for="contact in client.contacts" :key="contact.id" class="mb-3">
                    <v-card-text v-if="editingContact.id == contact.id">
                        <v-layout align-center>
                            <v-flex>
                                <v-layout class="mb-1" row wrap align-center>
                                    <v-flex md4>
                                        <v-text-field
                                            label="Name"
                                            v-model="contact.name"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex md4>
                                        <v-text-field
                                            label="Email"
                                            v-model="contact.email"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex md4 v-for="(field, key) in contact.custom_fields" :key="key">
                                        <v-layout align-center>
                                            <v-flex>
                                                <v-text-field
                                                    v-if="editField == key"
                                                    label="Edit Field"
                                                    v-model="field.name"
                                                ></v-text-field>
                                                <v-text-field
                                                    v-else
                                                    :label="field.name"
                                                    v-model="field.value"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex>
                                                <v-icon v-if="editField == null" @click="editField = key">edit</v-icon>
                                                <v-icon v-else @click="editField = null">save</v-icon>
                                                <v-icon @click="removeField(field)">delete_forever</v-icon>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex md4>
                                        <v-layout align-center>
                                            <v-text-field
                                                label="New Field"
                                                v-model="newField.name"
                                                @keydown.enter.prevent="addCustomField"
                                            ></v-text-field>
                                            <v-btn color="primary" @click="addCustomField">Add</v-btn>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                            <v-flex md1 class="text-xs-center">
                                <v-btn flat color="primary" @click="editContact(contact.id);">
                                    Save
                                </v-btn>
                                <v-btn flat color="error" @click="resetEditingContact">
                                    Cancel
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-layout align-center>
                            <v-flex>
                                <v-layout class="mb-1" row wrap align-center>
                                    <v-flex md4>
                                        <h4>Name</h4>
                                        {{contact.name}}
                                    </v-flex>
                                    <v-flex md4>
                                        <h4>Email:</h4>
                                        <a :href="'mailto:'+contact.email">{{contact.email}}</a>
                                    </v-flex>
                                    <v-flex md4 v-for="field in contact.custom_fields" :key="field.name">
                                        <h4>{{field.name}}:</h4>
                                        <a v-if="field.name == 'Phone'" :href="'tel:'+field.value">{{field.value}}</a>
                                        <span v-else>{{field.value}}</span>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                            <v-flex md1>
                                <v-btn flat icon color="white" @click="editingContact = contact">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <v-btn flat icon color="error" @click="removeContact(contact.id)">
                                    <v-icon>delete_forever</v-icon>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
            </section>
            <v-form v-if="addingContact" @submit.prevent="addContact">
                <v-card>
                    <v-card-title>
                        <h1 class="title">
                            Add Contact
                        </h1>
                    </v-card-title>
                    <v-card-text>
                        <v-layout row wrap align-center>
                            <v-flex md4>
                                <v-text-field
                                    label="Contact Name"
                                    v-model="contact.name"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md4>
                                <v-text-field
                                    label="Contact Email"
                                    v-model="contact.email"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md4 v-for="(field, key) in contact.custom_fields" :key="key">
                                <v-layout align-center>
                                    <v-flex>
                                        <v-text-field
                                            :label="field.name"
                                            v-model="field.value"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                            <v-flex md4>
                                <v-layout>
                                    <v-flex>
                                        <v-text-field
                                            label="Custom Field"
                                            v-model="newContactField.name"
                                            @keydown.enter.prevent="addCustomFieldToNewContact"
                                        ></v-text-field>
                                    </v-flex>
                                    <v-flex>
                                        <v-btn @click="addCustomFieldToNewContact" color="primary">Add Field</v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn flat color="error"  @click="addingContact = false">Cancel</v-btn>
                        <v-btn type="submit" color="primary">Add</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
            <v-btn v-else color="primary" @click="addingContact = true">
                <v-icon>add</v-icon> Add Another Contact
            </v-btn>
        </v-container>
    </v-container>
</template>

<script>
import Client from "../../app/models/Client";
import Contact from "../../app/models/Contact";
export default {
  data() {
    return {
      editField: null,
      editingContact: {
        id: null
      },
      contact: {
        custom_fields: []
      },
      client: null,
      addingContact: false,
      newField: {
        name: null
      },
      newContactField: {
        name: null
      }
    };
  },
  computed: {
    $client() {
      return new Client(this, "client");
    },
    $contact() {
      return new Contact(this, "contact");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.$client.find(this.$route.params.client);
      this.addingContact = false;
    },
    editContact() {
      let contact = this.editingContact;
      let data = {
        client_id: this.$route.params.client,
        name: contact.name,
        email: contact.email,
        custom_fields: JSON.stringify(contact.custom_fields)
      };
      this.$contact.update(this.editingContact.id, data).then(() => {
        this.resetEditingContact();
      });
    },
    resetEditingContact() {
      this.editingContact = {
        id: null
      };
    },
    addCustomField() {
      this.editingContact.custom_fields.push(this.newField);
      this.newField = {
        name: null
      };
    },
    addCustomFieldToNewContact() {
      this.contact.custom_fields.push(this.newContactField);
      this.newContactField = {
        name: null
      };
    },
    removeField(field) {
      this.contact.customFields.splice(
        this.contact.customFields.indexOf(field),
        1
      );
    },
    addContact() {
      let contact = this.contact;
      let data = {
        client_id: this.$route.params.client,
        name: contact.name,
        email: contact.email,
        custom_fields: JSON.stringify(contact.custom_fields)
      };
      this.$contact.create(data).then(() => {
        this.init();
        this.contact = {
          custom_fields: []
        };
      });
    },
    removeContact(contact) {
      this.$contact.delete(contact, this.init);
    }
  }
};
</script>

