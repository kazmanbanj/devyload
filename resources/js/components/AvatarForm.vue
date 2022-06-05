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
            <input type="file" name="avatar" id="avatar" accept="image/*" @change="onChange">

        </form>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props: ['user'],

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
        onChange(e) {
            if (! e.target.files.length) return;

            let avatar = e.target.files[0];

            let reader = new FileReader();

            reader.readAsDataURL(avatar);

            reader.onload = e => {
                this.avatar = e.target.result;
            };

            this.persist(avatar);
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