let user = window.App.user;

module.exports = {
    updateReply (reply) {
        return reply.user_id === user.id;
    },
    owns (model,prop = 'user_id') {
        return model[prop] == user.id;
    },
    isAdmin() {
        return ['NoNo1'].includes(user.name);
    },
};