<template>
    <div class="card mb-2">
        <div :id="'reply-'+id" class="card-header d-flex" :class="isBest ? 'reply-card-header' : ''">
            <p>
                <b>
                    <a :href="'/profiles/'+data.creator.name"
                        v-text="data.creator.name">
                    </a>
                </b>
                said <span v-text="ago"></span>
            </p>

            <div v-if="signedIn" class="ml-auto">
                <favorite :reply="data"></favorite>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <form action="" @submit.prevent="update">
                    <div class="form-group">
                        <!-- <wysiwyg v-model="body"></wysiwyg> -->

                        <!-- <textarea
                            class="form-control"
                            v-model="body"
                            required
                        ></textarea> -->
                        <textarea class="form-control"
                            name="body"
                            v-model="body"
                            @keydown.shift.enter="update"
                            required
                        ></textarea>
                    </div>

                    <button class="btn btn-sm btn-primary" type="submit">
                        Update
                    </button>
                    <button class="btn btn-sm btn-link" @click="cancelEdit" type="button">
                        Cancel
                    </button>
                </form>
            </div>

            <div class="body" v-else v-html="body"></div>
        </div>

        <div class="d-flex card-footer">
            <div v-if="authorize('updateReply', reply)">
                <button
                    class="btn btn-warning btn-sm"
                    type="button"
                    @click="editing = true"
                    v-if="!editing"
                >
                    Edit
                </button>
                <a
                    href="javascript:;"
                    class="btn btn-danger btn-sm ml-2"
                    type="button"
                    @click="destroy"
                    v-if="!editing"
                >
                    Delete
                </a>
            </div>

            <a
                href="javascript:;"
                class="btn btn-info btn-sm ml-auto"
                type="submit"
                @click="markBestReply"
                v-show="! isBest"
            >
                Best Reply
            </a>
        </div>
    </div>
</template>
<style>
    .reply-card-header
    {
        background-color: #28a7463d;
    }
</style>
<script>
import Favorite from "./Favorite.vue";
import moment from "moment";

export default {
    components: { Favorite },
    props: {
        data: {
            type: [Object, Array],
            required: true
        },
    },

    data() {
        return {
            editing: false,
            id: this.data.id,
            body: this.data.body,
            isBest: this.data.isBest,
            reply: this.data
        };
    },

    computed: {
        user() {
            return window.App.user;
        },
        ago() {
            return moment(this.data.created_at).fromNow() + '...';
        }
    },

    created() {
        window.events.$on('best-reply-selected', id => {
            this.isBest = (id === this.id);
        })
    },

    methods: {
        update() {
            axios.patch("/replies/" + this.data.id, {
                body: this.body,
            })
            .catch(error => {
                flash('error.response.data', 'danger');
            })
            .then(({data}) => {

                this.editing = false;

                flash("Updated!");
            });
        },

        destroy() {
            if(confirm("Do you really want to delete?")){
                axios.delete("/replies/" + this.data.id)
                .then(() => {
                    this.$emit('deleted');
                    flash("Your reply has been deleted.")
                });
            }
        },

        markBestReply() {
            axios.post('/replies/' + this.data.id + '/best')
            .then(() => {
                window.events.$emit('best-reply-selected', this.data.id);
                flash('You\'ve successfully marked the best reply.');
            });
        },

        cancelEdit() {
            this.reply.body = this.reply.body;

            this.editing = false;
        },
    },
};
</script>
