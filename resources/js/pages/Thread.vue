<script>
import Replies from "../components/Replies";
import SubscribeButton from '../components/SubscribeButton';

export default {
    props: {
        thread: {
            type: [Object, Array]
        },
    },

    components: { Replies, SubscribeButton },

    data() {
        return {
            repliesCount: this.thread.replies_count,
            locked: this.thread.locked,
            editing: false,
            subject: this.thread.subject,
            body: this.thread.body,
            form: {
                subject: this.thread.subject,
                body: this.thread.body,
            }
        }
    },
    methods: {
        toggleLock() {
            axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug)
                .then(() => {
                    this.locked = ! this.locked;
                });
        },

        // cancel() {
        //     this.resetForm();

            // this.form.subject = this.thread.subject;
            // this.form.body = this.thread.body;

            // this.editing = false;
        // },

        update() {
            let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

            axios.patch(uri, this.form)
            .then(() => {
                this.editing = false;
                this.subject = this.form.subject;
                this.body = this.form.body;

                flash('Your thread has been updated.');
            });
        },

        resetForm() {
            this.form = {
                subject: this.thread.subject,
                body: this.thread.body
            };

            this.editing = false;
        }
    },
}
</script>