<template>
    <div>
        <img :src="avatar" :alt="avatarAlt" width="50" height="50" class="mb-2">

        <div class="d-flex">
            <h3 v-text="user.name"></h3>
            <small class="ml-1" style="margin-top: 12px">
                joined
                <span v-text="timeJoined"></span>
            </small>
        </div>

        <form v-if="canUpdate" enctype="multipart/form-data">

        <image-upload name="avatar" class="form-control" @loaded="onLoad"></image-upload>

        </form>
    </div>
</template>

<script>
import ImageUpload from './ImageUpload.vue';
import moment from "moment";

export default {
    props: ['user'],

    components: { ImageUpload },

    data() {
        return {
            avatar: this.user.avatar_path,
            avatarAlt: this.user.name + "'s avatar",
        }
    },

    computed: {
        timeJoined() {
            return moment(this.user.created_at).fromNow() + '...';
        },
        canUpdate() {
            return this.authorize(user => user.id === this.user.id)
        }
    },

    methods: {
        onLoad(avatar) {
            this.avatar = avatar.src;
            this.persist(avatar.file);
        },

        persist(avatar) {
            let data = new FormData();

            data.append('avatar', avatar);

            axios.post(`/api/users/${this.user.name}/avatar`, data)
                .then(() => flash('Avatar uploaded!'));
        }
    },
}
</script>