<template>
    <div class="mt-5">
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

        <!-- <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            endpoint: '/threads/36/115/replies',
            body: ''
        }
    },
    methods: {
        addReply() {
            axios.post(this.endpoint, {
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