<template>
    <div>
        <div v-if="signIn">
            <div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
            </div>

            <button type="submit" class="btn btn-default" @click="addReply">
                提交
            </button>
        </div>

        <p class="text-center" v-else>
            请先<a href="/login">登录</a>，然后再发表回复
        </p>

    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body:'',
                completed:false
            };
        },

        computed: {
            signIn() {
                return window.App.signIn;
            }
        },

        mounted() {
            $('#body').atwho({
                at:"@",
                delay:750,
                callbacks: {
                    remoteFilter: function (query,callback) {
                        $.getJSON("/api/users",{name:query},function(usernames){
                            callback(usernames)
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body:this.body })
                    .catch(error => {
                        flash(error.response.data,'danger');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;

                        flash('Your reply has been posted.');

                        this.$emit('created',data);
                    });
            }
        }
    }
</script>