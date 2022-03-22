<template>
    <div>
        <li class="nav-item dropdown" v-if="notifications.length">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fa-solid fa-bell"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <a href="#" v-for="notification in notifications"  :key="notification.id" class="dropdown-item">
                    <a :href="notification.data.link" v-text="notification.data.message" @click.prevent="markAsRead(notification)"></a>
                </a>
            </div>
        </li>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: false
        }
    },

    created() {
        axios.get("/profiles/" + window.App.user.name + "/notifications")
            .then(response => this.notifications = response.data);
    },

    methods: {
        markAsRead(notification) {
            axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
        },
    },
}
</script>