<template>
    <div class="input-group">
        <input type="text" class="form-control" id="btn-input" name="message" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
        <div class="input-group-append">
            <button id="btn-chat" class="btn btn-primary" @click="sendMessage">Send</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],

        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            sendMessage() {

                this.$emit('messagesent', {
                    user: this.user,
                    message: this.newMessage,
                    requestId: document.querySelector("#request-id").value
                });

                this.newMessage = ''
            }
        }    
    }
</script>