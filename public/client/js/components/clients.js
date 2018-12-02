Vue.component("clients", {
    template: `
        <div>
            <div class="row" v-for="client in clients">
                <div class="col-sm-12" >
                    <h5 >
                        {{client.first_name}} {{client.last_name}}
                        <span class="badge badge-secondary">{{client.email}}</span>
                        <button type="button" class="btn btn-primary btn-sm" @click="addContactShow(client.id)">Add contact</button>
                        <button type="button" class="btn btn-danger btn-sm" @click="deleteClient(client.id)">Delete client</button>
                    </h5>
                    <add-contact v-bind:clientId="client.id"></add-contact>
                </div>
                <div class="col-sm-6" v-for="contact in client.contacts">
                    <div class="card" style="width: 18rem;" >
                      <div class="card-body">
                        <div class="card-text">
                            <p>Address: {{contact.address}}</p>
                            <p>Postcode: {{contact.postcode}}</p>
                        </div>
                        <a href="#" class="card-link" @click="deleteContact(client.id, contact.id)">Delete</a>
                      </div>
                    </div>
                    <br />
                </div>
            </div>
        </div>
    `,
    computed: {
        clients: function() {
            return store.state.clients;
        }
    },
    beforeMount: function() {
        store.dispatch("loadClients", {
            app: this
        });
    },
    methods: {
        addContactShow: function(clientId) {
            store.commit("setAddContactShown", clientId);
        },
        deleteClient: function(id) {
            store.dispatch("deleteClient", {
                app: this,
                client_id: id
            });
        },
        deleteContact: function(client_id, id) {
            store.dispatch("deleteContact", {
                app: this,
                client_id: client_id,
                contact_id: id
            });
        }
    }
});
