<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: '',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
                // this.body = this.message;
                // this.show = true;
            }

            window.events.$on('flash', message => this.flash(message));
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },

            hide() {
                // $('.alert-flash').delay(3000).fadeOut();
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            },
        },

        // mounted() {
        //     console.log('Component mounted.')
        // }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
