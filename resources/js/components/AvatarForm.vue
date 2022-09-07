<template>
    <div>
        <div class="d-flex">
            <img :src="avatar" :alt="avatarAlt" width="50" height="50" class="mb-2">

            <h3 class="ml-2" v-text="user.name" style="margin-top: 12px"></h3>
        </div>

        <small class="ml-1 mt-1">
            Joined <span v-text="timeJoined"></span>
        </small>

        <form v-if="canUpdate" enctype="multipart/form-data" class="mt-2">

        <image-upload name="avatar" class="form-control" @loaded="onLoad"></image-upload>

        </form>

        <hr>
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