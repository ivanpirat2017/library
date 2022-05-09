<template >
  <main class="main-login-p">
    <div class="logincentr">
      <div class="login">
        <h2 style="font-size: 36px">Регистрация</h2>

        <div class="item">
          <div
            class="alert alert-danger"
            v-if="error.last_name != null"
            role="alert"
          >
            {{ error.last_name[0] }}
          </div>
          <h4>Фамилия</h4>
          <input
            type="text"
            name="last_name"
            v-model="last_name"
            id="last_name"
          />
        </div>

        <div class="item">
          <div
            class="alert alert-danger"
            v-if="error.first_name != null"
            role="alert"
          >
            {{ error.first_name[0] }}
          </div>
          <h4>Имя</h4>
          <input
            type="text"
            name="first_name"
            v-model="first_name"
            id="first_name"
          />
        </div>

        <div class="item">
          <div
            class="alert alert-danger"
            v-if="error.patronymic != null"
            role="alert"
          >
            {{ error.patronymic[0] }}
          </div>
          <h4>Отчесво</h4>
          <input
            type="text"
            name="patronymic"
            v-model="patronymic"
            id="patronymic"
          />
        </div>

        <div class="item">
          <div
            class="alert alert-danger"
            v-if="error.email != null"
            role="alert"
          >
            {{ error.email[0] }}
          </div>
          <h4>email</h4>
          <input type="text" name="login" v-model="email" id="login" />
        </div>
        <div class="item">
          <div
            class="alert alert-danger"
            v-if="error.password != null"
            role="alert"
          >
            {{ error.password[0] }}
          </div>
          <h4>Пароль</h4>
          <input
            type="password"
            name="password"
            v-model="password"
            id="password"
          />
        </div>
        <div class="item">
          <div class="alert alert-danger" v-if="boolpassword" role="alert">
            Пароль введен неверно
          </div>
          <h4>Повтрите пароль</h4>
          <input
            type="password"
            name="password2"
            v-model="password2"
            id="password2"
          />
        </div>
        <div class="itembtn">
          <button class="btn book_button_grean loginbtn" @click="getToken()">
            Зарегистрироваться
          </button>
          <div>
            <router-link to="/login" class="link-grean">Войти</router-link>
            |
            <router-link to="/" class="link-grean"
              >Главная страница
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
import { REGISTER } from "../../api-routes";
export default {
  data() {
    return {
      login: "",
      password: "",
      password2: "",
      error: {},
      first_name: "",
      last_name: "",
      patronymic: "",
      email: "",
      boolpassword: false,
    };
  },
  methods: {
    getToken() {
      if (this.password != this.password2) {
        this.boolpassword = true;
        console.log("errr");
        return;
      }
      this.boolpassword = false;
      const form = new FormData();
      form.append("first_name", this.first_name);
      form.append("last_name", this.last_name);
      form.append("patronymic", this.patronymic);
      form.append("email", this.email);
      form.append("password", this.password);
      fetch(REGISTER, {
        method: "POST",
        body: form,
      })
        .then((r) => {
          if (r.status == 204) {
            this.$router.push("/login");
          } else {
            return r.json();
          }
        })
        .then((r) => {
          if (r.error != null) {
            this.error = r.error;
          }
        });
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
