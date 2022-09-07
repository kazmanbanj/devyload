<template>
    <div class="mt-5">
        <div v-if="signedIn">
            <div class="form-group">
                <textarea
                    id="body"
                    name="body"
                    rows="5"
                    class="form-control"
                    placeholder="Add new reply"
                    v-model="body"
                ></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-1" @click="addReply">Save</button>
        </div>

        <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate in this discussion</p>
    </div>
</template>


<script>
import 'at.js';
import 'jquery.caret';

export default {
    data() {
        return {
            body: ''
        }
    },

    mounted() {
        $('#body').atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    $.getJSON("/api/users", {name: query},
                        function (usernames) {
                            callback(usernames)
                        }
                    );
                }
            }
        })
    },

    methods: {
        addReply() {
            // axios.post(this.endpoint, {
            console.log(location.pathname);
            axios.post(location.pathname + '/replies', {
                body: this.body
            })
            .catch(error => {
                // flash(error.response.data.errors.body[0], 'danger');
                flash(error.response.data, 'danger');
            })
            .then(({data}) => {
                this.body = '';

                flash('Your reply has been posted');

                this.$emit('created', data);
            });
        },
    },
}
</script>
