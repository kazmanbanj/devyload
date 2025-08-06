<template>
    <div>
        <button :class="classes" type="submit" class="btn float-end" @click="toggle">
            <i class="fa-solid fa-heart"></i>
            <span v-text="count"></span>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        reply: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            count: this.reply.favorites_count,
            active: this.reply.is_favorited
        }
    },
    computed: {
        classes() {
            return [this.active ? 'btn-primary' : 'btn-default'];
        },

        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },

    methods: {
        toggle() {
            return this.active ? this.destroy() : this.create();
        },

        destroy() {
            axios.delete(this.endpoint);

            this.active = false;
            this.count--;
        },

        create() {
            axios.post(this.endpoint);

            this.active = true;
            this.count++;
        }
    },
}
</script>