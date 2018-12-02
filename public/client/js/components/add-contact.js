Vue.component("add-contact", {
    props: ["clientId"],
    template: `
        <div>
            <div class="row" v-if="shown">
                <div class="col-sm-12" >
                    <h3>Add contact</h3>
                    <form @submit.prevent="addContact">
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter address" v-model="contact.address"/>
                        <small v-if="error.address">{{error.address[0]}}</small>
                      </div>
                      <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" id="postcode" placeholder="Enter postcode" v-model="contact.postcode"/>
                        <small v-if="error.postcode">{{error.postcode[0]}}</small>
                      </div>
                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="button" class="btn btn-danger" @click="addContactHide()">Cancel</button>
                    </form>
                </div>
            </div>
            <br />

        </div>
    `,
    data: function() {
        return {
            contact: {
                address: "",
                postcode: ""
            }
        };
    },
    computed: {
        error: function() {
            return store.state.add_contact_error;
        },
        shown: function() {
            return store.state.add_contact_shown == this.clientId;
        }
    },
    beforeMount: function() {},
    methods: {
        addContact: function() {
            store.dispatch("addContact", {
                app: this,
                client_id: this.clientId,
                contact: this.contact
            });
        },
        addContactHide: function() {
            store.commit("setAddContactShown", 0);
        }
    }
});
