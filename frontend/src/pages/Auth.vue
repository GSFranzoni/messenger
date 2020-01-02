<template>
    <q-page class="row justify-center items-center">
        <q-card class="form">
            <q-card-section class='row justify-start'>
                <div class='text-h5'>{{ login? 'Login': 'Cadastro' }}</div>
            </q-card-section>
            <q-card-section>
                <q-input name='email' class='self-center' color="primary" outlined v-model="user.email" label="E-mail" type="email">
                <template v-slot:append>
                    <q-avatar>
                        <img src="https://image.flaticon.com/icons/svg/321/321817.svg" />
                    </q-avatar>
                </template>
            </q-input>
            </q-card-section>
            <q-card-section v-if='!login'>
                <q-input name='name' class='self-center' color="primary" outlined v-model="user.name" label="Nome" type="text">
                <template v-slot:append>
                    <q-avatar>
                        <img src="https://image.flaticon.com/icons/svg/145/145867.svg" />
                    </q-avatar>
                </template>
            </q-input>
            </q-card-section>
            <q-card-section>
                <q-input name='password' class='self-center' color="primary" outlined v-model="user.password" label="Senha" type="password">
                <template v-slot:append>
                    <q-avatar>
                        <img src="https://image.flaticon.com/icons/svg/526/526812.svg" />
                    </q-avatar>
                </template>
            </q-input>
            </q-card-section>
            <q-card-section class='row justify-end'>
                <p @click="login=!login" class='text-primary pointer'>{{ login? 'Ainda não possui uma conta?': 'Já possui uma conta?' }}</p>
            </q-card-section>
            <q-card-section v-if='login' class='row justify-end'>
                <q-btn @click='signin' outline color='primary' icon-right="mail" label="Entrar"></q-btn>
            </q-card-section>
            <q-card-section v-else class='row justify-end'>
                <q-btn @click='signin' outline color='primary' icon-right="mail" label="Cadastrar"></q-btn>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
import { baseApiUrl } from '../global';
import axios from 'axios';

export default {
    data: function() {
        return {
            user: {},
            login: true
        };
    },
    methods: {
        signin: function() {
            axios.post(`${baseApiUrl}/signin`, this.user).then(
                response => {
                    let user = response.data.data.user;
                    user['token'] = response.data.data.token;
                    this.$store.commit('setUser', user);
                    localStorage.setItem('user', JSON.stringify({ ...response.data.data.user, token: response.data.data.token }));
                    this.user = {};
                    this.$router.push({
                        path: '/'
                    })
                }
            ).catch(e => {
                alert(e.message)
            })
        },
        signup: function() {

        }
    }
};
</script>

<style>
.form {
    width: 400px;
    max-width: 90%;
}

.pointer {
    cursor: pointer;
}
</style>
