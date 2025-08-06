<template>
    <div>
        <button :class="classes" @click="toggleSubscription">
            {{ btnName }}
        </button>
    </div>
</template>

<script>
export default {
    props: {
        active: {
            type: Boolean,
            required: true
        },
    },

    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-secondary'];
        },
        btnName() {
            return this.active ? 'Unsubscribe' : 'Subscribe';
        }
    },

    methods: {
        toggleSubscription() {
            let requestType = this.active ? 'delete' : 'post';

            axios[requestType](location.pathname + '/subscriptions');

            this.active = ! this.active;

            let message = this.active ? 'Unsubscribed' : 'Subcribed';

            flash(message);
        },
    },
}
</script>