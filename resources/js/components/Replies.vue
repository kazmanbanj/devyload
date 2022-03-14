<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
import Reply from '../components/Reply.vue';
import NewReply from '../components/NewReply.vue';

export default {
    props: ['data'],

    components: { Reply, NewReply },

    data() {
        return {
            items: this.data
        }
    },

    methods: {
        add(reply) {
            this.items.push(reply);
        },
        
        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed');

            flash('Reply was deleted');
        },
    },
}
</script>