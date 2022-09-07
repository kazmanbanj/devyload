<template>
    <div>
        <button :class="classes" @click="subscribe">Subscribe</button>
    </div>
</template>

<script>
export default {
    props: ['active'],

    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-secondary'];
        },
    },

    methods: {
        subscribe() {
            let requestType = this.active ? 'delete' : 'post';

            axios[requestType](location.pathname + '/subscriptions');

            this.active = ! this.active;

            let message = this.active ? 'Unsubscribed' : 'Subcribed';

            flash(message);
        },
    },
}
</script>