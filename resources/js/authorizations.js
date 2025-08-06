let user = window.App.user;

module.exports = {
    updateReply (reply) {
        return reply.user_id === user.id;
    },

    isAdmin () {
        return ['jahojaho', 'jahojaho1'].includes(user.name);
    }
};