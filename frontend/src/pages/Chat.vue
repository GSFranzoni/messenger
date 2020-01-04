<template>
    <q-page v-if="to && user" class="chat column justify-end items-center">
        <transition-group
            name="flip-list"
            enter-active-class="animated slideInUp"
            leave-active-class="none"
            mode="out-in"
        >
            <q-chat-message
                v-for="msg in messages"
                :key="msg.id"
                :name="msg.from.name==user.name? 'Eu': msg.from.name"
                :stamp="msg.moment"
                :text="[msg.text]"
                :avatar="`https://api.adorable.io/avatars/45/${msg.from.name==user.name? user.id: to.id}.png`"
                :sent="msg.from.name==user.name"
            />
            <q-chat-message
                v-if="typing"
                key="99999"
                :name="to.name"
                :avatar="`https://api.adorable.io/avatars/45/${to.id}.png`"
            >
                <q-spinner-dots size="2rem" />
            </q-chat-message>
        </transition-group>
        <q-input class="message" v-model="message" label="Mensagem" @keyup.enter="sendMessage">
            <template v-slot:before>
                <q-avatar size="45px">
                    <img
                        :src="`https://api.adorable.io/avatars/45/${user.id}.png`"
                        alt="user-avatar"
                    />
                </q-avatar>
            </template>
            <template v-slot:after>
                <q-btn @click="sendMessage" round dense flat icon="send" />
            </template>
        </q-input>
        <div class="bottom"></div>
    </q-page>
</template>

<script>
import Gravatar from "vue-gravatar";
import { mapState, mapGetters } from "vuex";
import axios from "axios";
import { baseApiUrl, getRandomColor, getFormattedDate } from "../global.js";

export default {
    data: function() {
        return {
            messages: [],
            message: "",
            to: null,
            typing: false,
            chat: null
        };
    },
    computed: {
        ...mapGetters(["socket"]),
        ...mapState(["user"]),
    },
    methods: {
        getChat: async function() {
            await axios
                .post(`${baseApiUrl}/chats`, {
                    user1: this.user.id,
                    user2: this.to.id
                })
                .then(async response => {
                    this.chat = response.data.data;
                    await this.getMessages();
                })
                .catch(e => false);
        },
        getMessages: async function() {
            await axios
                .get(`${baseApiUrl}/chats/${this.chat.id}/messages`)
                .then(response => {
                    this.messages = response.data.data;
                });
        },
        sendMessage: function() {
            axios
                .post(`${baseApiUrl}/messages`, {
                    _to: this.to.id,
                    _from: this.user.id,
                    text: this.message,
                    moment: getFormattedDate(new Date())
                })
                .then(response => {
                    const msg = {
                        to: this.chat.id.toString(),
                        from: {
                            name: this.user.name,
                        },
                        message: this.message,
                        moment: getFormattedDate(new Date())
                    };
                    this.socket.emit("send", msg);
                    this.setMessage(msg);
                    this.message = "";
                });
        },
        verifyRoute: async function() {
            if (this.$route.params.to) {
                await axios
                    .get(`${baseApiUrl}/users/${this.$route.params.to}`)
                    .then(response => {
                        this.to = response.data.data;
                    });
            }
        },
        configureSocket: function() {
            this.socket.emit("joined", this.chat.id.toString());
            this.socket.on("message", data => {
                alert(JSON.stringify(data))
                this.setMessage(data);
            });
            this.socket.on("typing", data => {
                this.typing = data;
            });
        },
        setMessage: function(data) {
            this.messages.push({
                id: Math.random(99999),
                text: data["message"],
                from: {
                    name: data["from"]['name']
                },
                moment: data["moment"]
            });
        },
        color: function() {
            return getRandomColor();
        }
    },
    created: async function() {
        await this.verifyRoute();
        await this.getChat();
        this.configureSocket();
    },
    watch: {
        $route: async function(to) {        
            this.to.id = this.$route.params.to;
            this.socket.emit('leaved', this.chat.id.toString());
            await this.verifyRoute();
            await this.getChat();
            this.message = '';
            this.typing = false;
            this.configureSocket();
        },
        message: function() {
            if (this.message.length === 1) {
                this.socket.emit("typing", {
                    to: this.chat.id.toString(),
                    value: true
                });
            } 
            else if (this.message.length === 0) {
                this.socket.emit("typing", {
                    to: this.chat.id.toString(),
                    value: false
                });
            }
        }
    },
    filters: {
        upper: function(value) {
            return value.toUpperCase();
        }
    }
};
</script>

<style>
.flip-list-move {
    transition: transform 0.5s;
}
.chat {
    width: 100%;
    padding: 20px;
}

.chat > * {
    width: 100%;
}

.message {
    margin-top: 20px;
}

.none {
    opacity: 0;
}
</style>