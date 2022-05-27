<template  >
    <Placeholder v-if="loadingBool" />
    <InfoItem :closeInfo="closeInfo" v-if="!infopanel" :title="'Здравствуйте, вы у нас в первые раз? '"
        :textbody="'В этом разделе вы можете скачать книгу, оставить отзыв, вести диалоги о книги - в чате, а также просмотреть карточку пользователя (нажав на его аватарку). Удачного времяпровождения! '"
        :textbody2="' P.s некоторые возможности сайта, доступны только авторизированным пользователем.'" />
    <main class="m5-l-r">
        <ButtonGoBack />
        <h2 style="font-size: 36px" class="m5-p-b title">{{ bookinfo.title }}</h2>
        <div class="adout_book">
            <div class="adout_book_img">
                <img :src="img" class="book_img_title" alt="" />
            </div>
            <div class="adout_book_content">
                <p class="genre">Жанр книги: {{ bookinfo.genrename }}</p>
                <p class="reting">
                    Рейтинг: <span>{{ bookinfo.reting }}/5</span>
                </p>
                <p class="author">Автор книги: {{ bookinfo.author }}</p>
                <p class="date">Дата написания: {{ bookinfo.release }}</p>
                <p class="status">Статус книги: {{ bookinfo.status }}</p>
                <p class="status">Книгу просмотрели : {{ watchbook }} раз</p>
                <div class="">
                    <button class="book_button_grean btn" v-if="auth" @click="download()">
                        скачать
                    </button>
                    <button class="btn-warning btn" v-else @click="$router.push('/login')">
                        для скачивания нужна авторизация
                    </button>
                    <button class="btn-dark btn" v-if="auth" @click="$router.push('/read/' + bookinfo.id)">
                        Читать книгу
                    </button>
                    <img :src="startext" alt="" height="30" @click="btnclickstar()" class="FavoritesImg-adout" />
                </div>

                <p>
                    Чат (alpha)
                    <router-link :to="'/chatbook/' + bookId">открыть</router-link>
                </p>


            </div>
        </div>

        <div class="adout_book_text">
            <h2 class="m5-p-b">Описание книги</h2>
            <p class="description">{{ bookinfo.description }}</p>
        </div>
        <h2 class="m5-p-b" v-if="auth">Написать комментарий</h2>
        <div class="alert alert-info" role="alert" v-if="update">
            Комментарий находится на рассмотрении
        </div>
        <div class="alert alert-danger" role="alert" v-if="errr">
            Введите более 10 символов
        </div>
        <div class="adout_book_text_edit" v-if="auth">
            <div class="adout_book_text_edit_content">
                <div contenteditable class="editcomment"></div>
                <button class="book_button_grean btn_send btn" id="btnaddcomment" @click="setComment()">
                    <img src="../../../static/img/send.png" tabindex="0" alt="" />
                </button>

            </div>
        </div>
        <div class="toast    show align-items-center text-white bg-danger border-0" v-else role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Привет! Вы не авторизованы, по этому не можете писать комментарии.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Закрыть"></button>
            </div>
        </div>
        <div class="adout_book_title" v-if="filtersComment.length != 0">
            <h2 class="m5-p-b">Комментарий к книге</h2>
            <select class="form-select" v-model="checkComment" aria-label="фильтрация">
                <option selected value="1">по умолчанию</option>
                <option value="3">по возрастанию лайков</option>
                <option value="2">по убыванию лайков</option>

            </select>
        </div>
        <div class="adout_book_comments">
            <div v-if="filtersComment.length == 0">
                <h3>Список комментариев пуст</h3>
            </div>
            <Message :item="item" v-for="item in filtersComment" :key="item.id" />
        </div>
    </main>
</template>
<script>
import {
    getApi,
    GET_GENRE_BOOK_ID,
    GET_COMMENT_BOOK_ID,
    ADD_COMMENT,
    authCheck,
    ADD_WATCH_BOOK,
    DOUMLONDDOOK,
} from "../../api-routes";
import Message from "../../components/items/Bookadout/Message.vue";
import InfoItem from "../../components/items/InfoItem.vue";
import Placeholder from "../../components/items/Placeholder.vue";
import ButtonGoBack from "../../components/items/ButtonGoBack.vue";
import imagebook from "../../../static/img/bookimg.png";
import Favorites from "../../../static/img/favorites.png";
import FavoritesFull from "../../../static/img/favorites-full.png";
export default {
    components: {
        Message,
        Placeholder,
        InfoItem,
        ButtonGoBack,
    },
    beforeUnmount() {
        clearInterval(this.timeComent);
    },
    computed: {
        auth() {
            return this.$store.getters.getpauth
        },
        filtersComment() {
            const arr = [...this.comments];
            if (this.checkComment == 1) {
                return arr;
            }
            if (this.checkComment == 2) {
                return arr.sort(function (a, b) {
                    if (a.sum_like > b.sum_like) {
                        return -1;
                    }
                    if (a.sum_like < b.sum_like) {
                        return 1;
                    }
                    return 0;
                })
            }
            if (this.checkComment == 3) {
                return arr.sort(function (a, b) {
                    if (a.sum_like > b.sum_like) {
                        return 1;
                    }
                    if (a.sum_like < b.sum_like) {
                        return -1;
                    }
                    return 0;
                })
            }
        }
    },
    data() {
        return {
            cartArrId: JSON.parse(localStorage.getItem("cartid")) ?? [],
            bookinfo: {},
            comments: [],
            watchbook: 0,
            textcomet: "",
            checkComment: 1,
            bookId: this.$route.params.id,
            startext: null,
            img: "",
            timeComent: null,
            loadingBool: true,
            update: false,
            errr: false,
            infopanel: localStorage.getItem("infopanel"),
        };
    },
    mounted() {
        this.$store.dispatch('AUTH_CHECK');
        this.addwatchbook(+this.bookId);
        if (this.cartArrId.includes(+this.bookId)) {
            this.startext = FavoritesFull;
        } else {
            this.startext = Favorites;
        }

        this.timeComent = setInterval(() => {
            this.getcomment();
        }, 5000);

        this.getcomment();
        getApi(GET_GENRE_BOOK_ID + this.bookId).then((r) => {
            this.bookinfo = r.data;
            this.loadingBool = false;
            this.img = this.bookinfo.bookimg
                ? "/storage/" + this.bookinfo.bookimg
                : imagebook;

            this.watchbook = r.watch;
        });
    },
    methods: {
        closeInfo() {
            this.infopanel = !this.infopanel;
            localStorage.setItem("infopanel", true);
        },
        download() {
            window.open(DOUMLONDDOOK + +this.bookId, "_blank");
        },
        addwatchbook(id) {
            fetch(ADD_WATCH_BOOK + id, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
        },
        setComment() {
            const editcomment = document.querySelector(".editcomment");
            const form = new FormData();
            form.append("message", editcomment.textContent);
            form.append("book_comment_id", this.bookId);
            if (editcomment.textContent.length < 10) {
                this.errr = true;
                setTimeout(() => {
                    this.errr = false;
                }, 3000);
            } else {
                fetch(ADD_COMMENT, {
                    method: "POST",
                    body: form,
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("token"),
                    },
                }).then((r) => {
                    editcomment.textContent = "";
                    this.getcomment();
                    this.update = true;
                    setTimeout(() => {
                        this.update = false;
                    }, 3000);
                });
            }
        },
        getcomment() {
            getApi(GET_COMMENT_BOOK_ID + this.bookId).then((r) => {
                this.comments = r.data;
            });
        },
        btnclickstar() {
            if (!this.cartArrId.includes(+this.bookId)) {
                this.cartArrId.push(+this.bookId);
                this.startext = FavoritesFull;
            } else {
                this.cartArrId.splice(this.cartArrId.indexOf(+this.bookId), 1);
                this.startext = Favorites;
            }
            this.$root.cartArrId = this.cartArrId;
            localStorage.setItem("cartid", JSON.stringify(this.cartArrId));
        },
    },
};
</script>
<style  lang='scss'>
.FavoritesImg-adout {
    opacity: 0.85;

    cursor: pointer;
}

.logo_user {
    display: flex;
    flex-shrink: 0;
    justify-content: center;
    align-items: center;
    width: 90px;
    height: 90px;
    overflow: hidden;
    border-radius: 100%;
    margin-right: 10px;

    @media (max-width: 1200px) {
        width: 60px;
        height: 60px;
        margin-right: 10px;
    }

    a {
        width: 100%;
        height: 100%;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
}

.adout_book {
    display: flex;
    flex-direction: row;
    gap: 20px;

    @media (max-width: 700px) {
        flex-direction: column;
    }

    &_title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        @media (max-width: 550px) {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        h2 {
            white-space: nowrap;
            margin: 0;
        }

        select {
            height: 50px;
            display: flex;
            flex: 1 0;
            max-width: 300px;
        }
    }

    &_comments {
        padding: 20px 0;
    }

    &_comment {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        &_img {
            display: flex;
            background-color: rgb(240, 240, 240);
            padding: 10px;
            border-radius: 10px;
            border: #ffffff 3px solid;
            box-shadow: rgba(1, 0, 61, 0.301) 0 10px 20px;
            margin-bottom: 30px;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        &_content {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-direction: row;

            p {
                width: 98%;

                @media (max-width: 1200px) {
                    width: 95%;
                }
            }

            div {
                font-size: 1rem;
                margin-left: 5px;
                width: 65px;
                text-align: end;
                cursor: pointer;
            }
        }
    }

    &_text {
        padding-bottom: 25px;
        border-bottom: #0c2d0c 2px solid;
        margin-bottom: 10px;

        &_edit {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            padding-bottom: 25px;

            &_content {
                display: flex;
                width: 100%;
                align-items: flex-end;

                &_like_on {
                    color: rgb(145, 28, 255);
                    position: relative;
                }

                &_like_off {
                    color: rgb(255, 28, 28);
                    position: relative;
                }

                &_like_dell {
                    color: rgb(22, 18, 37);
                    position: relative;
                }
            }
        }
    }

    &_content {
        div {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
        }

        p {
            margin-bottom: 15px;
            font-family: "mr";
            font-size: 1.2rem;

            span {
                color: rgb(255, 99, 9);
                font-size: 1.3rem;

                @media (max-width: 800px) {
                    font-size: 1.4rem;
                }

                font-family: "mb";
            }
        }
    }

    &_img {
        height: 500px;

        @media (max-width: 700px) {
            width: 80%;
            height: auto;
        }

        img {
            width: 100%;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.137) 0 10px 20px;
        }
    }
}

.editcomment {
    width: 100%;
    padding: 6px;
    border-radius: 5px;
    margin-right: 10px;
    border: #1e5945 3px solid;

    &:focus {
        outline: none;
    }
}
</style>
