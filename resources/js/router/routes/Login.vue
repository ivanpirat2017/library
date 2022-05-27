<template >
    <Placeholder v-if="loadingBool" />
    <main class="main-login-pm">
        <div class="logincentr">
            <div class="login">
                <h2 style="font-size: 36px">Вход</h2>
                <div class="item">
                    <div class="alert alert-danger" v-if="error.email != null" role="alert">
                        {{ error.email[0] }}
                    </div>
                    <h4>email</h4>
                    <input type="text" name="login" data-mask="(999) 999-9999" v-model="login" id="login" />
                </div>
                <div class="itembtn">
                    <button class="btn book_button_grean loginbtn" @click="getToken()">
                        Войти
                    </button>
                    <div>
                        <router-link to="/registration" class="link-grean">Регистрация</router-link>
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
import { LOGIN } from "../../api-routes";
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
            loadingBool: true,
            check: false
        };
    },
    mounted() {
        this.loadingBool = !imglouder()
    },
    methods: {
        getToken() {
            if (this.check) {
                return 0;
            }
            this.check = true
            const form = new FormData();
            form.append("email", this.login);
            form.append("browser", navigator.userAgent.toLowerCase());
            fetch(LOGIN, {
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
                    this.check = false
                });
        },
    },
};
</script>
<style lang="scss">
input {
    background: none;
}

.p_t-50px {
    padding-top: 20vh;
}

.login {
    width: 400px;
    border: #0c2d0c 3px solid;
    border-radius: 10px;
    padding: 15px;
    margin: 5px;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    flex-basis: 1;
    box-shadow: 0 0 100px rgba(75, 75, 75, 0.678);

    .item {
        input {
            width: 100%;
            font-size: 1.3rem;
            outline: none;
            margin: 10px 0;
            border: none;
            border-bottom: #0c2d0c 2px solid;
        }
    }

    h2 {
        margin-bottom: 30px;
    }

    @media (max-width: 700px) {
        width: 100%;
        margin: 0;
        padding: 50px;
        height: 100%;
        border-radius: 20px 20px 0 0;
        border: white 5px solid;
        box-shadow: 0 -100px 100px rgba(82, 255, 160, 0.378),
            inset 0 0 30px rgba(0, 24, 54, 0.4);
    }

    .itembtn {
        margin-top: 20px;

        div {
            margin-top: 20px;

        }
    }
}

.logincentr {
    width: 100vw;
    height: 80vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.main-login-pm {
    min-height: 100vh;
    display: flex;
    justify-content: center;

    flex-direction: column;
    width: 100vw;
    background-blend-mode: multiply;

    @media (max-width: 700px) {
        min-height: 100vh;
        background: url(../../../static/img/background.jpg);
        justify-content: end;
    }


}

.main-login-p {
    min-height: 100vh;
    display: flex;
    justify-content: center;

    flex-direction: column;
    width: 100vw;
    background-blend-mode: multiply;

    @media (max-width: 700px) {
        min-height: 100vh;
        background: url(../../../static/img/background.jpg);
        justify-content: end;
    }

    @media (max-height: 900px) {
        min-height: 130vh;
    }
}
</style>
