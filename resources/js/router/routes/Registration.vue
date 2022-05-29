<template >
    <Placeholder v-if="loadingBool" />
    <main class="main-login-p">
        <div class="logincentr">
            <div class="login">
                <h2 style="font-size: 36px">Регистрация</h2>
                <div class="alert alert-warning" role="alert" v-if="loadingFetch">
                    идет проверка данных, пожалуйста дождитесь ответа!
                </div>
                <div class="item">
                    <div class="alert alert-danger" v-if="error.last_name != null" role="alert">
                        {{ error.last_name[0] }}
                    </div>
                    <h4>Фамилия</h4>
                    <input type="text" name="last_name" v-model="last_name" id="last_name" />
                </div>

                <div class="item">
                    <div class="alert alert-danger" v-if="error.first_name != null" role="alert">
                        {{ error.first_name[0] }}
                    </div>
                    <h4>Имя</h4>
                    <input type="text" name="first_name" v-model="first_name" id="first_name" />
                </div>

                <div class="item">
                    <div class="alert alert-danger" v-if="error.patronymic != null" role="alert">
                        {{ error.patronymic[0] }}
                    </div>
                    <h4>Отчество</h4>
                    <input type="text" name="patronymic" v-model="patronymic" id="patronymic" />
                </div>

                <div class="item">
                    <div class="alert alert-danger" v-if="error.email != null" role="alert">
                        {{ error.email[0] }}
                    </div>
                    <h4>Email</h4>
                    <input type="text" name="login" v-model="email" id="login" />
                </div>
                <div class="itembtn">
                    <button class="btn book_button_grean loginbtn" @click="Reg()">
                        Зарегистрироваться
                    </button>
                    <div>
                        <router-link to="/login" class="link-grean">Войти</router-link>
                        |
                        <router-link to="/" class="link-grean">Главная страница
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import { REGISTER } from "../../api-routes";
import { imglouder } from "../../script/imglouder";
import Placeholder from "../../components/items/Placeholder.vue";
export default {
    components: {
        Placeholder,
    },
    data() {
        return {
            login: "",
            error: {},
            first_name: "",
            last_name: "",
            patronymic: "",
            email: "",
            boolpassword: false,
            loadingBool: true,
            loadingFetch: false

        };
    },
    mounted() {
        this.loadingBool = !imglouder()
    },
    methods: {
        Reg() {
            this.boolpassword = false;
            const form = new FormData();
            form.append("first_name", this.first_name);
            form.append("last_name", this.last_name);
            form.append("patronymic", this.patronymic);
            form.append("browser", navigator.userAgent.toLowerCase());
            form.append("email", this.email);
            this.loadingFetch = true
            fetch(REGISTER, {
                method: "POST",
                body: form,
            })
                .then((r) => {
                    if (r.status == 204) {
                        this.$router.push('/checkemail')
                    } else {
                        return r.json();
                    }
                })
                .then((r) => {
                    if (r.error != null) {
                        this.error = r.error;
                    }
                }).finally(r => {
                    this.loadingFetch = false
                });;
        },
    },
};
</script>
<style scope>
input {
    background: none;
}

.logincentr {
    height: auto;
}
</style>
