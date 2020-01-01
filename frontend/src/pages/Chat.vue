<template>
    <q-page v-if="to && user" class="chat column justify-end items-center">
        <transition-group
            name="flip-list"
            enter-active-class="animated slideInUp"
            leave-active-class="none"
            mode="out-in"
        >
            <q-chat-message
                v-for="message in chat"
                :key="message.id"
                :name="message.from==$store.state.user.name? 'Eu': message.from"
                :stamp="message.moment"
                :text="[message.text]"
                :avatar="`https://api.adorable.io/avatars/45/${message.from==$store.state.user.name? user.id: to.id}.png`"
                :sent="message.from==$store.state.user.name"
            />
            <q-chat-message 
                v-if='typing' 
                key='9999999999'
                :name="to.name"
                :avatar="`https://api.adorable.io/avatars/45/${to.id}.png`"
            >
                <q-spinner-dots size="2rem" />
            </q-chat-message>
        </transition-group>
        <q-input class="message" v-model="message" label="Mensagem" @keyup.enter="sendMessage" >
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
import { mapState } from "vuex";
import axios from "axios";
import { baseApiUrl, getRandomColor, getFormattedDate } from "../global.js";

const io = require("socket.io-client");
const socket = io("http://localhost:3000");

export default {
    data: function() {
        return {
            chat: [],
            message: "",
            to: null,
            typing: false
        };
    },
    computed: mapState(["user"]),
    methods: {
        getChat: function() {
            axios
                .post(`${baseApiUrl}/chat`, {
                    user1: this.user.id,
                    user2: this.to.id
                })
                .then(response => {
                    this.chat = response.data.data;
                })
                .catch(e => false);
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
                    socket.emit("send", {
                        to: "MYCHAT",
                        from: this.user.name,
                        message: this.message,
                        moment: getFormattedDate(new Date())
                    });
                    this.chat.push({
                        id: Math.random(999999),
                        text: this.message,
                        from: this.user.name,
                        moment: getFormattedDate(new Date())
                    });
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
            socket.emit("joined", "MYCHAT");
            socket.on("message", data => {
                this.chat.push({
                    id: Math.random(99999),
                    text: data["message"],
                    from: data["from"],
                    moment: data['moment']
                });
            });
            socket.on("typing", data => {
                this.typing = data;
            });
        },
        color: function() {
            return getRandomColor();
        }
    },
    created: async function() {
        await this.verifyRoute();
        this.getChat();
        this.configureSocket();
    },
    watch: {
        $route: async function(to) {
            this.to.id = this.$route.params.to;
            await this.verifyRoute();
            this.getChat();
            this.configureSocket();
        },
        message: function() {
            if (this.message.length === 1) {
                socket.emit("typing", {
                    to: "MYCHAT",
                    value: true
                });
            } else if (this.message.length === 0) {
                socket.emit("typing", {
                    to: "MYCHAT",
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