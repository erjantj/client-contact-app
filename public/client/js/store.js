const store = new Vuex.Store({
    state: {
        auth_token: "c5aa7a2367eba62037bc9515ebc579002f57e4fc",
        clients: [],
        add_client_shown: false,
        add_client_error: {},
        add_contact_shown: 0,
        add_contact_error: {},
        import_batch_error: {}
    },
    mutations: {
        setClients: function(state, clients) {
            this.state.clients = clients;
        },
        setAuthToken: function(state, token) {
            this.state.auth_token = token;
        },
        setContacts: function(state, contacts) {
            this.state.contacts = contacts;
        },
        setAddClientShown: function(state, status) {
            this.state.add_client_shown = status;
        },
        setAddClientError: function(state, error) {
            this.state.add_client_error = error;
        },
        setAddContactShown: function(state, status) {
            this.state.add_contact_shown = status;
        },
        setAddContactError: function(state, error) {
            this.state.add_contact_error = error;
        },
        setImportBatchError: function(state, error) {
            this.state.import_batch_error = error;
        }
    },
    actions: {
        loadClients: function(state, { app }) {
            state.commit("setClients", []);
            app.$loadClients()
                .then(function(response) {
                    state.commit("setClients", response.data);
                })
                .catch(function(error) {
                    state.commit("setClients", []);
                })
                .then(function() {
                    // always executed
                });
        },
        addClient: function(state, { app, client }) {
            app.$addClient(client)
                .then(function(response) {
                    app.client = {};
                    app.$toasted.show("User saved", {
                        theme: "primary",
                        position: "top-center",
                        duration: 5000
                    });
                    store.commit("setAddClientShown", false);
                    store.dispatch("loadClients", { app: app });
                })
                .catch(function(error) {
                    state.commit("setAddClientError", error.response.data);
                })
                .then(function() {
                    // always executed
                });
        },
        addContact: function(state, { app, client_id, contact }) {
            app.$addContact(client_id, contact)
                .then(function(response) {
                    app.client = {};
                    app.$toasted.show("Contact saved", {
                        theme: "primary",
                        position: "top-center",
                        duration: 5000
                    });
                    store.commit("setAddContactShown", 0);
                    store.dispatch("loadClients", { app: app });
                })
                .catch(function(error) {
                    state.commit("setAddContactError", error.response.data);
                })
                .then(function() {
                    // always executed
                });
        },
        importBatch: function(state, { app, file }) {
            app.$importBatch(file)
                .then(function(response) {
                    app.$toasted.show("Users imported", {
                        theme: "primary",
                        position: "top-center",
                        duration: 5000
                    });
                    store.dispatch("loadClients", { app: app });
                })
                .catch(function(error) {
                    state.commit("setImportBatchError", error.response.data);
                })
                .then(function() {
                    // always executed
                });
        },
        deleteClient: function(state, { app, client_id }) {
            app.$deleteClient(client_id)
                .then(function(response) {
                    app.$toasted.show("Client deleted", {
                        theme: "primary",
                        position: "top-center",
                        duration: 5000
                    });
                    store.dispatch("loadClients", { app: app });
                })
                .catch(function(error) {})
                .then(function() {
                    // always executed
                });
        },
        deleteContact: function(state, { app, client_id, contact_id }) {
            app.$deleteContact(client_id, contact_id)
                .then(function(response) {
                    app.$toasted.show("Contact deleted", {
                        theme: "primary",
                        position: "top-center",
                        duration: 5000
                    });
                    store.dispatch("loadClients", { app: app });
                })
                .catch(function(error) {})
                .then(function() {
                    // always executed
                });
        }
    }
});
