<script>
    import Replies from '../components/Replies';
    import SubscribeButton from '../components/SubscribeButton';

    export default {
        props: ['thread'],

        components: { Replies,SubscribeButton},

        data() {
            return {
                repliesCount:this.thread.replies_count,
                locked:this.thread.locked,
                title:this.thread.title,
                body:this.thread.body,
                form:{},// 改为 created() 设置初始值
                editing:false
            };
        },

        created() {
            this.resetForm();
        },

        update() {
            axios.patch('/threads/' + this.thread.channel.slug + '/' + this.thread.slug,{
                title:this.form.title,
                body:this.form.body
            }).then(() => {
                this.editing = false;
                this.title = this.form.title;
                this.body = this.form.body;

                flash('Your thread has been updated.');
            });
        },

        resetForm() {
            this.form.title = this.thread.title;
            this.form.body = this.thread.body;

            this.editing = false;
        },

        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            }
        }
    }
</script>