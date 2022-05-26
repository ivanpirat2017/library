<template>
    <main class="m5-l-r BookAboutAdmin">
        <h2 style="font-size: 36px" class="m5-p-b title"> <input type="text" v-model="title"></h2>
        <div class="adout_book">
            <div class="adout_book_img_adm">
                <img :src="img" class="book_img_title" alt="" />
                <input class="form-control" type="file" id="bookimg" />
            </div>
            <div class="adout_book_content">
                <p class="genre">Жанр книги:
                    <select class="form-select" v-model="genre_book_id" aria-label="фильтрация">
                        <option v-for="item in genres" :value="item.id" :key="item.id">{{ item.genrename }}</option>
                    </select>
                </p>
                <p class="reting">
                    Рейтинг: <span> <input type="number" max="5" min="0" step="0.1" v-model="reting"> </span>
                </p>
                <p class="author">Автор книги: : <input type="text" v-model="author"></p>
                <p class="date">Дата написания: <input type="text" v-model="release"></p>
                <p class="status">Статус книги:
                    <select class="form-select" v-model="book_status_id" aria-label="фильтрация">
                        <option v-for="item in statuses" :value="item.id" :key="item.id">{{ item.status }}</option>
                    </select>
                </p>
                <p> <label for="formFile" class="form-label">файл книги</label>
                    <input class="form-control" type="file" id="bookurl" />
                </p>
                <button class="btn  btn-primary " @click="editBook()">
                    сохранить
                </button>
            </div>
        </div>

        <div class="adout_book_text">
            <h2 class="m5-p-b">Описание книги</h2>
            <p class="description" contenteditable>{{ bookinfo.description }}</p>
        </div>

    </main>
</template>
<script>
import {
    getApi,
    GET_GENRE_BOOK_ID,
    GET_STARUSES,
    GET_ALL_GENRES,
    BOOK_UPDATE
} from "../../../api-routes";
import imagebook from "../../../../static/img/bookimg.png";
export default {

    data() {
        return {
            bookinfo: {},
            bookId: this.$route.params.id,
            startext: null,
            img: "",
            title: "",
            author: "",
            description: "",
            genre_book_id: null,
            book_status_id: null,
            bookimg: "",
            bookurl: "",
            reting: 0,
            release: "",
            genres: [],
            statuses: []
        };
    },
    mounted() {
        this.getBook()
        this.getGanres();
        this.getStatus();
    },
    methods: {
        getGanres() {
            getApi(GET_ALL_GENRES).then((r) => {
                this.genres = r.data;

            });
        },
        getStatus() {
            getApi(GET_STARUSES).then((r) => {
                console.log(r);
                this.statuses = r.data;
            });
        },
        getBook() {
            getApi(GET_GENRE_BOOK_ID + this.$route.params.id).then((r) => {
                this.bookinfo = r.data;
                this.genre_book_id = r.data.genreid;
                this.book_status_id = r.data.statusid;
                this.title = r.data.title;
                this.author = r.data.author;
                this.release = r.data.release;
                this.img = this.bookinfo.bookimg
                    ? "/storage/" + this.bookinfo.bookimg
                    : imagebook;
            });
        },
        async editBook() {
            const bookimg = await document.querySelector("#bookimg");
            const bookurl = await document.querySelector("#bookurl");
            const descriptiontext = await document.querySelector(".description");

            const formdata = new FormData();
            await formdata.append("id", this.bookinfo.id);
            await formdata.append("title", this.title);
            await formdata.append("author", this.author);
            await formdata.append("description", descriptiontext.textContent);
            await formdata.append("genre_book_id", this.genre_book_id);
            await formdata.append("book_status_id", this.book_status_id);
            await formdata.append("reting", this.reting);
            await formdata.append("release", this.release);
            await formdata.append("bookimg", bookimg.files[0]);
            await formdata.append("bookurl", bookurl.files[0]);
            console.log(this.id)
            await fetch(BOOK_UPDATE, {
                method: "POST",
                body: formdata,
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.getBook()
                    alert("книга обновлена");
                }
            });
        },

    }
}

</script>
<style lang="scss" scoped>
.book_img_title {
    width: 300px;
}

.BookAboutAdmin {

    input,
    .description {
        border: none;
        outline: none;
        border: 2px #1E5945 solid;
        padding: 3px;
        border-radius: 5px;
        width: 100%;
    }
}
</style>


