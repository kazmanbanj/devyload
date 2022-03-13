<template>
    <div>
        <button :class="classes" type="submit" class="float-end" @click="toggle">
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
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited
        }
    },
    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-outline-secondary'];
        },
        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },
    methods: {
        toggle() {
            return this.active ? this.destroy() : this.create();
        },
        create() {
            axios.post(this.endpoint);

            this.active = true;
            this.count++;
        },
        destroy() {
            axios.delete(this.endpoint);

            this.active = false;
            this.count--;
        }
    },
}
</script>