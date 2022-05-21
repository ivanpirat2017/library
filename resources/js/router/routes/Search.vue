<template >
    <Placeholder v-if="loadingBool" />
    <div class="loading"></div>
    <main>
        <h2 class="m5-l-r t-pt-35 name_ganr" style="font-size: 36px">Поиск</h2>
        <div class="search t-mt-35">
            <div class="search_content m5-l-r">
                <h4 class="t-pt-35">Найти книгу</h4>
                <div class="inputsearch">
                    <input type="text" class="form-control" id="searchbook" v-model="search"
                        placeholder="поиск книг по жанрам , названию , дате" @keyup.enter="setSearch()" />
                    <button class="btn" id="searchbookclick" @click="setSearch()">
                        поиск
                    </button>
                </div>
            </div>
        </div>
        <h1 class="m5-l-r name_ganr" style="font-size: 3rem"></h1>
        <div class="book_genres_content">
            <div class="book_genres_content_item m5-l-r">
                <div class="d-flex align-items-center t-pt-35">
                    <div>
                        <h3>Результаты поиска</h3>
                        <h5 class="searcbookText">
                            По запросу <b>{{ $route.query.query }}</b>, {{ countBook }}.
                        </h5>
                    </div>
                </div>

                <div class="books searcbook  ">
                    <img class="not_search_bad" v-if="books.length == 0" src="../../../static/img/sad.png" alt=""
                        srcset="" />
                    <Book :item="item" v-for="(item, id) in books" :key="id" />
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import { getApi, SEARCH_BOOK } from "../../api-routes";
import Placeholder from "../../components/items/Placeholder.vue";
import Book from "../../components/items/Book.vue";

export default {
    components: {
        Book,
        Placeholder,
    },
    data() {
        return {
            search: this.$route.query.query ?? "",
            books: [],
            loadingBool: true,
        };
    },
    mounted() {
        this.getBook();
    },
    methods: {
        setSearch() {
            this.$router.push("/search?query=" + this.search);
            this.getBook();
        },
        getBook() {
            getApi(SEARCH_BOOK + this.search).then((r) => {
                this.books = r.data;
                this.loadingBool = false;
            }).catch(r => this.getBook());
        },
    },
    computed: {
        countBook() {
            if (this.books.length == 0) {
                return "книг не найдено";
            } else if (this.books.length == 1) {
                return "Найдено " + this.books.length + " книга";
            } else if (this.books.length < 5) {
                return "Найдено " + this.books.length + " книги";
            } else if (this.books.length > 4) {
                return "Найдено " + this.books.length + " книг";
            }
        },
    },
};
</script>
<style lang='scss'>
.book_genres_content {
    padding-bottom: 40px;
}

.not_search_bad {
    width: 200px;

    @media (max-width: 600px) {
        width: 50%;
    }
}
</style>
