<template>
    <div>
        <button class="btn btn-primary" @click="subscribe()">Subscribe</button>
    </div>
</template>

<script>
export default {
    methods: {
        subscribe() {
            axios.post(location.pathname + '/subscriptions');

            flash('Subcribed');
        },
    },
}
</script>