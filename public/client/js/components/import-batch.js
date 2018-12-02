Vue.component("import-batch", {
    template: `
        <form >
            <div class="form-group">
                <input type="file" v-model="file" @change="importBatch"/>
                <small v-if="error.file">{{error.file[0]}}</small>
            </div>
        </form>
    `,
    data: function() {
        return {
            file: null
        };
    },
    computed: {
        error: function() {
            return store.state.import_batch_error;
        }
    },
    methods: {
        importBatch: function(event) {
            var file = event.target.files[0];
            store.dispatch("importBatch", {
                app: this,
                file: file
            });
        }
    }
});
