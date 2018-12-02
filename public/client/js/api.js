var axiosApi = axios.create({
    baseURL: "http://localhost:8000/api/v1",
    timeout: 4000
});

var Api = {
    install: function(Vue, options) {
        //private
        var myPrivateProperty = "Private property";

        Vue.prototype.$loadClients = function() {
            var token = store.state.auth_token;
            console.log(token);
            return axiosApi.get("/client", {
                headers: { Authorization: token }
            });
        };

        Vue.prototype.$addClient = function(client) {
            var token = store.state.auth_token;
            return axiosApi.post("/client", client, {
                headers: { Authorization: token }
            });
        };

        Vue.prototype.$addContact = function(client_id, contact) {
            var token = store.state.auth_token;
            return axiosApi.post(`/client/${client_id}/contact`, contact, {
                headers: { Authorization: token }
            });
        };

        Vue.prototype.$importBatch = function(file) {
            var token = store.state.auth_token;

            var formData = new FormData();
            formData.append("file", file);

            return axiosApi.post(`/client/import`, formData, {
                "content-type": "multipart/form-data",
                headers: { Authorization: token }
            });
        };

        Vue.prototype.$deleteClient = function(client_id) {
            var token = store.state.auth_token;
            return axiosApi.delete(`/client/${client_id}`, {
                headers: { Authorization: token }
            });
        };

        Vue.prototype.$deleteContact = function(client_id, contact_id) {
            var token = store.state.auth_token;
            return axiosApi.delete(
                `/client/${client_id}/contact/${contact_id}`,
                {
                    headers: { Authorization: token }
                }
            );
        };
    }
};
