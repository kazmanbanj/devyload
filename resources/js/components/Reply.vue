<template>
    <div class="card mb-2">
        <div :id="'reply-'+id" class="card-header d-block">
        <p class="">
            <b>
                <a :href="'/profiles/'+data.creator.name"
                    v-text="data.creator.name">
                </a>
            </b>
            said {{ data.created_at }}
        </p>

        <!-- @if (Auth::check())
        <div>
            <favorite :reply="{{ $reply }}"></favorite>
        </div>
        @endif -->
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea
                        name=""
                        id=""
                        class="form-control"
                        v-model="body"
                    ></textarea>
                </div>

                <button class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <div class="body" v-else v-text="body"></div>
        </div>

        <!-- @can('update', $reply) -->
            <div class="d-flex ml-2 mb-2">
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
        <!-- @endcan -->
    </div>
</template>
<script>
import Favorite from "./Favorite.vue";

export default {
    props: ["data"],

    components: { Favorite },

    data() {
        return {
            editing: false,
            body: this.data.body,
            id: this.data.id
        };
    },
    methods: {
        update() {
            axios.patch("/replies/" + this.data.id, {
                body: this.body,
            });

            this.editing = false;
            flash("Updated!");
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
    },
};
</script>
