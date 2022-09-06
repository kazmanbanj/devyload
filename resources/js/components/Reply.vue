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
                <form @submit="update">
                    <div class="form-group">
                        <textarea
                            class="form-control"
                            v-model="body"
                            required
                        ></textarea>
                    </div>

                    <button class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>

            <div class="body" v-else v-html="body"></div>
        </div>

        <div class="d-flex card-footer">
            <div v-if="canUpdate">
                <button
                    class="btn btn-warning btn-sm"
                    type="submit"
                    @click="editing = true"
                >
                    Edit
                </button>
                <a
                    href="javascript:;"
                    class="btn btn-danger btn-sm ml-2"
                    type="submit"
                    @click="destroy"
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
    props: ["data"],

    components: { Favorite },

    data() {
        return {
            editing: false,
            id: this.data.id,
            body: this.data.body,
            isBest: false
        };
    },

    computed: {
        ago() {
            return moment(this.data.created_at).fromNow() + '...';
        },

        signedIn() {
            return window.App.signedIn;
        },

        canUpdate() {
            return this.authorize(user => this.data.user_id == user.id);
        }
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
                axios.delete("/replies/" + this.data.id);

                this.$emit('deleted', [this.data.id]);

                // $(this.$el).fadeOut(300, () => {
                //     flash("Your reply has been deleted.");
                // });
            }
        },

        markBestReply() {
            this.isBest = true;
        },
    },
};
</script>
