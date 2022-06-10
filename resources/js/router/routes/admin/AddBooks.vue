<template  >
    <div class="container  ">
        <div class="form d-flex flex-column bg-dark p-5 ml-3  mr-3">

            <a href="https://bookfor.ru">сайт для парсера</a>
            <div class="mb-2">
                <button type="button" @click="setComent()" class="btn btn-primary">
                    Создать комментарии ко всем книгам
                </button>
                <div class="mb-2">
                    <img id="canvasid" />
                </div>
                <h2>Найти книги по URL</h2>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">
                        genre
                    </label>
                    <input type="text" v-model="genre" class="form-control" id="exampleFormControlInput1"
                        placeholder="genre" />
                </div>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">
                        URL
                    </label>
                    <input type="text" v-model="urlbook" class="form-control" id="exampleFormControlInput1"
                        placeholder="URL" />
                </div>
                <button type="button" @click="parser()" class="btn btn-primary">
                    найти
                </button>
            </div>
            <div class="mb-2">
                <h2>Создать жанр</h2>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">аббревиатура жанра на английском
                    </label>
                    <input type="text" v-model="genre" class="form-control" id="exampleFormControlInput1"
                        placeholder="введите аббревиатуру" />
                </div>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">Назавание жанра
                    </label>
                    <input type="text" v-model="genrename" class="form-control" id="exampleFormControlInput1"
                        placeholder="введите назавание" />
                </div>
                <button type="button" @click="createGanre()" class="btn btn-primary">
                    Создать жанр
                </button>
            </div>
            <div class="mb-2">
                <h2>Создать стутус</h2>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">Назавание стутус
                    </label>
                    <input type="text" v-model="status" class="form-control" id="exampleFormControlInput1"
                        placeholder="введите назавание" />
                </div>
                <button type="button" @click="createStatus()" class="btn btn-primary">
                    Создать статус
                </button>
            </div>
            <h2>добавть книгу</h2>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label text-light">Назавание книги</label>
                <input type="text" v-model="title" class="form-control" id="exampleFormControlInput1"
                    placeholder="введите назавание" />
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label text-light">Описание</label>
                <textarea type="text" v-model="description" class="form-control" rows="6" id="exampleFormControlInput1"
                    placeholder="введите Описание" />
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label text-light">Выбирите жанр</label>
                <select class="form-select" v-model="genre_book_id" aria-label="Default select example">
                    <option v-for="(item, index) in genres" :key="index" :value="item.id">
                        {{ item.genrename }}
                    </option>
                </select>
            </div>
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label text-light">Выбирите Статус</label>
                <select class="form-select" v-model="book_status_id" aria-label="Default select example">
                    <option v-for="(item, index) in statuses" :key="index" :value="item.id">
                        {{ item.status }}
                    </option>
                </select>
                <div class="mb-2 pt-2">
                    <label for="formFile" class="form-label text-light">Обложка книги</label>
                    <input class="form-control" type="file" id="bookimg" />
                </div>
                <div class="mb-2 pt-2">
                    <label for="formFile" class="form-label text-light">файл книги</label>
                    <input class="form-control" type="file" id="bookurl" />
                </div>
                <div class="mb-2">
                    <label for="customRange1" class="form-label text-light">Рейтинг {{ reting }}</label>
                    <input type="range" v-model="reting" class="form-range" min="0" step="0.1" max="5"
                        id="customRange1" />
                </div>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">дата написания</label>
                    <input type="text" v-model="release" class="form-control" id="exampleFormControlInput1"
                        placeholder="введите дату" />
                </div>
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label text-light">Автор</label>
                    <input type="text" v-model="author" class="form-control" id="exampleFormControlInput1"
                        placeholder="введите Автора" />
                </div>
                <button type="button" class="btn btn-primary" @click="setBook()">
                    Создать книгу
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import {
    CREATE_BOOKS,
    GET_ALL_GENRES,
    getApi,
    CREATE_GENRE,
    CREATE_STARUS,
    GET_STARUSES,
    GET_BOOK_PARSER,
    SEARCH_BOOK,
    DELETE_BOOK,
} from "../../../api-routes";

export default {
    data() {
        return {
            title: "",
            author: "",
            description: "",
            genre_book_id: null,
            book_status_id: "",
            bookimg: "",
            bookurl: "",
            reting: 0,
            release: "",
            genres: [],
            genre: "",
            genrename: "",
            status: "",
            statuses: [],
            urlbook: "",
            books: [],
            searchbook: "",
        };
    },
    mounted() {
        this.getGanres();
        this.getStatus();
    },
    methods: {
        setComent() {
            document.location.href = '/api/setucoment'
        },
        dellbook(i) {
            fetch(DELETE_BOOK + i, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => this.setSearch());
        },
        setSearch() {
            getApi(SEARCH_BOOK + this.searchbook).then((r) => {
                this.books = r.data;
            });
        },

        parser() {
            for (let i = 0; i < 40; i++) {
                this.searchBook(this.urlbook + "page/" + i);
            }
        },
        searchBook(url) {
            const formdata = new FormData();
            formdata.append("url", url);
            formdata.append("gnr", this.genre);
            console.log(this.urlbook);
            fetch(GET_BOOK_PARSER, {
                method: "POST",
                body: formdata,
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
        },
        getStatus() {
            getApi(GET_STARUSES).then((r) => {
                console.log(r);
                this.statuses = r.data;
            });
        },
        createStatus() {
            const formdata = new FormData();
            formdata.append("status", this.status.toLowerCase());
            fetch(CREATE_STARUS, {
                method: "POST",
                body: formdata,
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.status = "";
                    this.getStatus();
                    alert("Cтатус создан");
                }
            });
        },
        createGanre() {
            const formdata = new FormData();
            formdata.append("genre", this.genre.toLowerCase().replace(" ", ""));
            formdata.append("genrename", this.genrename.toLowerCase());
            fetch(CREATE_GENRE, {
                method: "POST",
                body: formdata,
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.genre = "";
                    this.genrename = "";
                    this.getGanres();
                    alert("жанр создан");
                }
            });
        },
        getGanres() {
            getApi(GET_ALL_GENRES).then((r) => {
                this.genres = r.data;
            });
        },
        async setBook() {
            const imgparser = await document.getElementById("canvasid");
            const bookimg = await document.querySelector("#bookimg");
            const bookurl = await document.querySelector("#bookurl");
            console.log(imgparser.textContent);

            const formdata = new FormData();
            await formdata.append("title", this.title);
            await formdata.append("author", this.author);
            await formdata.append("description", this.description);
            await formdata.append("genre_book_id", this.genre_book_id);
            await formdata.append("book_status_id", this.book_status_id);
            await formdata.append("reting", this.reting);
            await formdata.append("release", this.release);
            await formdata.append("bookimg", bookimg.files[0]);
            await formdata.append("bookurl", bookurl.files[0]);
            await fetch(CREATE_BOOKS, {
                method: "POST",
                body: formdata,
                headers: {
                    Accept: "multipart/form-data",
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.title = "";
                    this.author = "";
                    this.description = "";
                    this.genre_book_id = null;
                    this.book_status_id = "";
                    this.bookimg = "";
                    this.bookurl = "";
                    this.reting = 0;
                    this.release = "";
                    alert("книга  создана");
                }
            });
        },
    },
};
</script>
<style lang="scss" scoped>
.form {
    border-radius: 10px;

    h2 {
        color: white;
    }
}

th,
td {
    button {

        @media (max-width: 500px) {
            font-size: 0.7rem;
            padding: 3px 2px;
        }
    }

    @media (max-width: 500px) {
        font-size: 0.8rem;
        padding: 2px;
    }
}
</style>
