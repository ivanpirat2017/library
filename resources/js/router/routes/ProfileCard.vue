<template  >
    <div class="profilePlaceholder " v-if="loder">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
    </div>
    <div class="m5-l-r">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card boder-shodow-radius">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center">
                                <div class="circle-img">
                                    <img :src="avatarImg" alt="Admin" />
                                </div>
                                <div class="mt-3">
                                    <h4>{{ last_name }} {{ first_name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-start">
                                <div class="mt-1">
                                    <h2>Обо мне</h2>
                                    <div class="d-flex align-items-start">
                                        <p class="editihtext" contenteditable>
                                            {{ about_information }}
                                        </p>
                                        <img height="15" style="margin-left: 5px" src="../../../static/img/draw.png"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3 boder-shodow-radius">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Фамилия</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" id="f" v-model="last_name" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Имя</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" id="i" v-model="first_name" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Отчесво</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" id="o" v-model="patronymic" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" id="email" v-model="email" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Логотип</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="file" class="form-control" name="avatar" id="avatar" />
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Фон карточки</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="file" class="form-control" name="aboutimg" id="aboutimg" />
                                </div>
                            </div>
                            <hr />

                            <div class="alert alert-info" role="alert" v-if="update">
                                Данные в профиле успешно обновлены
                            </div>
                            <div class="row">
                                <div class="col-sm-12 d-flex-wrap-gap">
                                    <button class="btn  " @click="updatedProfil()">
                                        <img src="../../../static/img/floppy-disk.png" height="40" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <router-link class="btn btn-primary" v-if="admin" to="/admin">кабинет админа</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
import {
    UPDATE_PROFILE,
    authAdminCheck,
} from "../../api-routes";
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
            first_name: '',
            last_name: "",
            patronymic: "",
            email: "",
            id: null,
            avatar: "",
            avatarImg: null,
            about_img: "",
            about_information: "",
            update: false,
            loder: true,
            admin: false,
        };
    },
    mounted() {
        authAdminCheck().then((r) => {
            if (r.status == 200) {
                this.admin = true;
            }
        });
    },
    watch: {
        getUserPrifile() {
        }
    },
    computed: {
        loadingBool() {
            return this.$store.getters.getloading
        },
        getUserPrifile() {
            this.first_name = this.$store.getters.getprofile.first_name;
            this.last_name = this.$store.getters.getprofile.last_name;
            this.patronymic = this.$store.getters.getprofile.patronymic;
            this.email = this.$store.getters.getprofile.email;
            this.avatar = this.$store.getters.getprofile.avatar;
            this.about_img = this.$store.getters.getprofile.about_img;
            this.about_title = this.$store.getters.getprofile.about_title;
            this.about_information =
                this.$store.getters.getprofile.about_information ?? "напиши свой текст";
            this.avatarImg = "/storage/" + this.avatar;
            this.loder = false
        }
    },
    methods: {
        closeInfo() {
            this.infopanel = !this.infopanel;
            localStorage.setItem("infopanelprofile", false);
        },
        async updatedProfil() {
            const aboutimg = await document.querySelector("#aboutimg");
            const avatar = await document.querySelector("#avatar");
            const editihtext = await document.querySelector(".editihtext");
            const formdata = new FormData();
            await formdata.append("first_name", this.first_name);
            await formdata.append("last_name", this.last_name);
            await formdata.append("patronymic", this.patronymic);
            await formdata.append("email", this.email);
            await formdata.append("about_information", editihtext.textContent);
            await formdata.append("avatar", avatar.files[0]);
            await formdata.append("about_img", aboutimg.files[0]);
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
                setTimeout(() => {
                    this.update = false;
                }, 3000);
            });
        },
    },
};
</script>
<style scope  lang='scss' >
input[type="file"] {
    font-size: 1rem;
}

.d-flex-wrap-gap {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.openuser {
    background: #711be2;
    color: white;

    @media (max-width: 410px) {
        margin: 0;

    }
}

.p-t-50 {
    padding-top: 50px;
}

.p-b-50 {
    padding-bottom: 50px;
}

.d-flex-wrap {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: flex-start;
}

.boder-shodow-radius {
    border-radius: 15px;
    box-shadow: rgb(2 0 51 / 20%) 0 0 30px;
    overflow: hidden;
}

.circle-img {
    width: 150px;
    height: 150px;
    overflow: hidden;
    border-radius: 100%;
    position: relative;

    img {
        width: 150px;
        height: 150px;
        position: absolute;
        object-fit: cover;
        text-align: none;
    }
}

.text-secondary {
    input {
        color: white;
        background: #1b2b3b;

        &:focus {
            color: white;
            background: #1b2b3b;
        }
    }
}

.editihtext:focus {
    outline: none;
    border-bottom: #112d32 2px solid;
}

.btn-exit {
    background: #e72424;
    box-shadow: #800000b2 0 0 50px;
    color: white;
    padding: 10px 5px;
    border-radius: 5px;

    @media (max-width: 410px) {
        font-size: 0.7rem;
    }
}
</style>
