Vue.component("add-client", {
    template: `
        <div>
            <div class="row" v-if="shown">
                <div class="col-sm-12" >
                    <h3>Add client</h3>

                    <form @submit.prevent="addClient">
                      <div class="form-group">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control" id="first_name is_invalid" placeholder="Enter first name" v-model="client.first_name"/>
                        <small v-if="error.first_name">{{error.first_name[0]}}</small>
                      </div>
                      <div class="form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Enter last name" v-model="client.last_name"/>
                        <small v-if="error.last_name">{{error.last_name[0]}}</small>
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter last name" v-model="client.email" />
                        <small v-if="error.email">{{error.email[0]}}</small>
                      </div>
                      <button type="submit" class="btn btn-primary">Save</button>
                      <button type="button" class="btn btn-danger" @click="addClientHide()">Cancel</button>
                    </form>
                </div>
            </div>
            <br />

        </div>
    `,
    data: function() {
        return {
            client: {
                first_name: "",
                last_name: "",
                email: ""
            }
        };
    },
    computed: {
        error: function() {
            return store.state.add_client_error;
        },
        shown: function() {
            return store.state.add_client_shown;
        }
    },
    beforeMount: function() {},
    methods: {
        addClient: function() {
            store.dispatch("addClient", {
                app: this,
                client: this.client
            });
        },
        addClientHide: function() {
            store.commit("setAddClientShown", false);
        }
    }
});
