<template  >
    <Placeholder v-if="loadingBool" />
    <div v-if="notAuth" class="cardUser m5-l-r">
        <div class="cardUserinfo">
            <div class="cardUserinfologo">
                <img :src="img" alt="" />
            </div>
            <div class="cardUserinfoimg">
                <img :src="aboutImg" alt="" />
            </div>
            <div class="cardUserinfotext">
                <h2>{{ user.first_name }} {{ user.last_name }}</h2>
                <h4>О себе</h4>
                <p>
                    {{ user.about_information }}
                </p>
                <div class="cardUserinfotextlikecount">
                    <h5>
                        Оставлено {{ user.sum_comments }}
                        <img src="../../../static/img/comments.png" height="20" alt="" />
                        отзывов
                    </h5>
                    <h5>
                        Лайкнуто {{ user.sum_likes }}
                        <img src="../../../static/img/heart.png" height="20" alt="" />
                        комментариев
                    </h5>
                    <h5>
                        Пользователь посетил {{ user.sum_watchbooks.allWatch }}
                        <img height="20" src="../../../static/img/view.png" />книг
                    </h5>
                    <h5>

                        {{ user.sum_watchbooks.uniqueWatch }} книг ункальные
                        <img height="20" src="../../../static/img/book.png" />
                    </h5>
                </div>
                <h2 class="cardUserinfotexth2">Достижения</h2>
            </div>

            <div class="cardUserinfoAward">
                <Award v-for="item in Awards" :key="item.id" :item='item' />
            </div>
        </div>
    </div>
    <div v-else-if="!notAuth && !loadingBool && this.$route.params.id" class="m5-l-r notAuth">
        <h2 v-if="err">
            Неизвестная ошибка
            <img src="../../../static/img/system.png" height="60" alt="" />
            <router-link to="/">-Домой?</router-link>
        </h2>
        <h2 v-else>
            Доступ запрещен
            <img src="../../../static/img/access.png" height="40" alt="" />
            <router-link to="/login">Войдите</router-link>
        </h2>
    </div>
</template>
<script>
import { GET_USER, GET_AWARD } from "../../api-routes";
import backgroundUser from "../../../static/img/backgroundUser.jpg";
import Placeholder from "../../components/items/Placeholder.vue";
import Award from "../../components/items/Award.vue";
import avatar from "../../../static/img/avatar.png";
export default {
    components: {
        Placeholder,
        Award,
    },
    data() {
        return {
            user: null,
            notAuth: null,
            img: null,
            err: false,
            aboutImg: null,
            Awards: [],
        };
    },
    computed: {
        loadingBool() {
            if (this.notAuth === false) {
                return false
            }
            if (!this.$route.params.id) {

                return false
            }

            return this.user ? false : true
        }
    },
    mounted() {
        this.getUser();

    },
    methods: {
        getUser() {
            fetch(GET_USER + (this.$route.params.id ?? this.$store.getters.getprofile.id), {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    }
                    if (r.status == 401) {
                    } else {
                        this.err = true;
                    }
                })
                .then((r) => {
                    this.getAward();
                    this.user = r.data;
                    this.img = this.user.avatar ? "/storage/" + this.user.avatar : avatar;
                    this.aboutImg = this.user.about_img
                        ? "/storage/" + this.user.about_img
                        : backgroundUser;
                    this.notAuth = true
                })
                .catch((r) => {
                    this.notAuth = false
                    this.getUser()
                })

        },
        getAward() {
            fetch(GET_AWARD + (this.$route.params.id ?? this.$store.getters.getprofile.id), {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    }
                    if (r.status == 401) {
                    } else {
                        this.err = true;
                    }
                })
                .then((r) => {
                    this.Awards = r.data;
                })
                .catch((r) => this.getAward());
        },
    },
};
</script>
<style lang="scss">
$height-back: 250px;

.notAuth {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
}

.cardUser {

    display: flex;
    align-items: center;
    justify-content: center;


    &info {
        max-width: 1200px;
        min-height: 400px;
        background: white;
        margin: 20px;
        box-shadow: 0 0 100px rgba(0, 0, 0, 0.2);
        border-radius: 30px;
        overflow: hidden;
        position: relative;

        &Award {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0 20px;
            padding-bottom: 20px;
        }

        &text {
            padding: 20px;
            padding-top: 75px;
            display: flex;
            flex-direction: column;

            &likecount {
                margin-top: 10px;
            }

            h2 {
                text-align: center;
            }

            &h2 {
                margin-top: 15px;
            }

            h5 {
                border-bottom: 2px solid rgba(128, 128, 128, 0.2);
                width: auto;
                font-size: 1.5rem;
            }
        }

        &logo {
            width: 150px;
            height: 150px;
            border: solid 3px rgb(255, 255, 255);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
            position: absolute;
            border-radius: 100%;
            overflow: hidden;
            top: $height-back;
            left: 50%;
            z-index: 4;
            transform: translateX(-50%) translateY(-50%);

            img {
                width: 100%;
                height: 100%;
                position: absolute;
                object-fit: cover;
            }

            @media (max-width: 400px) {
                width: 100px;
                height: 100px;
            }
        }

        &img {
            width: 100%;
            min-width: 90vw;
            height: $height-back;
            overflow: hidden;

            img {
                width: 100%;
                height: $height-back;
                z-index: 2;
                position: absolute;
                object-fit: cover;
            }
        }
    }
}
</style>
