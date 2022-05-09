<template  >
    <InfoItem :closeInfo="closeInfo" v-if="infopanel" :title="'Коллекция'"
        :textbody="'Вы впервые создали коллекцию, она отображается внизу вашей страницы, при нажатие на неё она раскроется и там будут ваши книги.'" />

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
    <h2 class="m5-l-r p-t-50 name_ganr" v-if="collections.length != 0">
        Ваша коллекция книг
    </h2>
    <h2 class="m5-l-r p-t-50 name_ganr" v-else>Ваша коллекция книг пуста</h2>
    <div v-if="collections.length != 0" class="accordion m5-l-r mb-3 boder-shodow-radius"
        id="accordionPanelsStayOpenExample">
        <div class="accordion-item bg-white" v-for="(collection, i) in collections"
            :key="collection.namecollection + i + collection.id">
            <h2 class="accordion-header" :id="'panelsStayOpen-headingThree' + i">
                <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                    :data-bs-target="'#panelsStayOpen-collapseThree' + i" aria-expanded="false"
                    :aria-controls="'panelsStayOpen-collapseThree' + i">
                    <div class="d-flex justify-content-between container-fluid">
                        <h5>{{ collection.namecollection }}</h5>
                        <button type="button" class="btn btn-danger" @click.prevent="dellCollection(collection.id, i)">
                            X
                        </button>
                    </div>
                </button>
            </h2>
            <div :id="'panelsStayOpen-collapseThree' + i" class="accordion-collapse collapse"
                :aria-labelledby="'panelsStayOpen-headingThree' + i">
                <div class="accordion-body books d-flex-wrap">
                    <Book :item="item" :collection="true" v-for="(item, id) in collection.books" :key="id" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    GET_PROFILE,
    UPDATE_PROFILE,
    GET_COLLECTION,
    DELL_COLLECTION,
    authAdminCheck,
} from "../../api-routes";

import Placeholder from "../../components/items/Placeholder.vue";
import Background from "../../../static/img/avatar.png";
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
            first_name: "",
            last_name: "",
            patronymic: "",
            email: "",
            id: null,
            avatar: "",
            avatarImg: null,
            about_img: "",
            about_information: "",

            update: false,
            password: "",
            collections: [],
            admin: false,
            infopanel: JSON.parse(localStorage.getItem("infopanelprofile")) ?? null,
        };
    },
    mounted() {
        this.getProfile();
        this.getCollec();
        authAdminCheck().then((r) => {
            if (r.status == 200) {
                this.admin = true;
            }
        });
    },
    computed: {
        loadingBool() {
            return this.first_name ? false : true
        }
    },
    methods: {
        closeInfo() {
            this.infopanel = !this.infopanel;
            localStorage.setItem("infopanelprofile", false);
        },
        getCollec() {
            fetch(GET_COLLECTION, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    } else {
                        alert("ошибка на сервере");
                    }
                })
                .then((r) => {
                    this.collections = r.data;

                    if (this.collections.length > 0) {
                        if (this.infopanel == null) {
                            this.infopanel = true;

                        }
                    }
                });
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
            await formdata.append("password", this.password);
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
                this.getProfile();
                this.update = true;
                setTimeout(() => {
                    this.update = false;
                }, 3000);
            });
        },
        dellCollection(id) {
            this.collections.splice(i, 1);

            fetch(DELL_COLLECTION + id, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.getCollec();
                } else {
                    alert("ошибка на сервере");
                }
            });
        },
        getProfile() {
            fetch(GET_PROFILE, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    } else {
                        alert("ошибка на сервере");
                    }
                })
                .then((r) => {
                    this.first_name = r.data.first_name;
                    this.last_name = r.data.last_name;
                    this.patronymic = r.data.patronymic;
                    this.email = r.data.email;
                    this.avatar = r.data.avatar;
                    this.about_img = r.data.about_img;
                    this.about_title = r.data.about_title;
                    this.about_information =
                    r.data.about_information ?? "напиши свой текст";
                    this.avatarImg = this.avatar ? "/storage/" + this.avatar : Background;
                })
                .catch((r) => { });
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
    box-shadow: rgba(2, 0, 51, 0.295) 0 0 60px;
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
