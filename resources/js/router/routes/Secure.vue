<template  >

    <div class="m5-l-r">
        <div class="main-body">
            <div class="row gutters-sm">

                <div class="col-md-8">
                    <div class="card mb-3 boder-shodow-radius">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Новый пароль</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" class="form-control" name="password" id="password"
                                        v-model="password" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Повторите пароль</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="password" class="form-control" name="passwordrepeat"
                                        id="passwordrepeat" v-model="passwordrepeat" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h5 class="mb-0">Введите капчу</h5>
                                </div>
                                <div class="col-sm-9  SecureInput">
                                    <h4>{{ num1 }}</h4>+<h4>{{ num2 }}</h4>
                                    <h4>=</h4>
                                    <input type="text" class="form-control" v-model="sum" name="ch" id="ch" />
                                </div>
                            </div>
                            <hr />
                            <div class="alert alert-info" role="alert" v-if="update">
                                Пароль изменён
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex-wrap-gap">
                                    <button class="btn  btn-primary" @click="updatedProfil()">
                                        Изменить пароль
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import { UPDATE_PROFILE } from "../../api-routes";
import Placeholder from "../../components/items/Placeholder.vue";
import InfoItem from "../../components/items/InfoItem.vue";
import Book from "../../components/items/Book.vue";
import ButtonGoBack from "../../components/items/ButtonGoBack.vue";
export default {
    components: {
        Placeholder,
        Book,
        InfoItem,
        ButtonGoBack,
    },
    data() {
        return {
            update: false,
            password: "",
            passwordrepeat: "",
            admin: false,
            num1: 1,
            num2: 0,
            sum: 0
        };
    },
    mounted() {
        this.captcha()
    },


    methods: {
        captcha() {
            if ((this.num1 + this.num2) == +this.sum) {
                return true;
            }
            this.num1 = Math.round(Math.random() * 20)
            this.num2 = Math.round(Math.random() * 20)
            return false;
        },
        async updatedProfil() {

            if (this.captcha()) {
                if (this.password == this.passwordrepeat) {
                    const formdata = new FormData();
                    await formdata.append("password", this.password);
                    await fetch(UPDATE_PROFILE, {
                        method: "POST",
                        body: formdata,
                        headers: {
                            Accept: "multipart/form-data",
                            Authorization: "Bearer " + localStorage.getItem("token"),
                        },
                    }).then((r) => {
                        this.$store.dispatch('GET_API_PROFILE')
                        this.update = true;
                        this.num1 = Math.round(Math.random() * 20)
                        this.num2 = Math.round(Math.random() * 20)
                        setTimeout(() => {
                            this.update = false;
                        }, 3000);
                    });
                }

            }

        },
    },
};
</script>
<style scope  lang='scss' >
.SecureInput {
    display: flex;
    align-items: center;

    h4 {
        margin: 0;
    }

    input {
        color: black;
        font-family: 'mm';
        font-size: 1.3em;

        &:focus {
            color: black;
        }
    }
}
</style>

