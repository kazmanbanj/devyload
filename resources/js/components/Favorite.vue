<template>
    <div>
        <button class="btn btn-outline-info float-end" @click="toggle">
            <i class="fa-solid fa-heart"></i>
            <span v-text="favoritesCount"></span>
            <!-- {{ $reply->favorites_count }} -->
        </button>
    </div>
</template>

<script>
export default {
    props: ['reply'],
    data() {
        return {
            favoritesCount: this.reply.favoritesCount
        }
    },
    methods: {
        toggle() {
            if (this.isFavorited) {
                axios.delete('/replies/' + this.reply.id + '/favorites');
            } else {
                axios.post('/replies/' + this.reply.id + '/favorites');
            }
        },
    },
}
</script>