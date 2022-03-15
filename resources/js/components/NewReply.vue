<template>
    <div class="mt-5">
        <div v-if="signedIn">
            <div class="form-group">
                <textarea 
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
export default {
    // props: ['endpoint'],

    data() {
        return {
            body: ''
        }
    },

    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },

    methods: {
        addReply() {
            // axios.post(this.endpoint, {
            axios.post(location.pathname + '/replies', {
                'body': this.body
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