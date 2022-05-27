<template >
    <Placeholder v-if="loadingBool" />
    <div class="loading"></div>
    <main>
        <h2 class="m5-l-r logo t-mt-35" style="font-size:48px">Поиск</h2>
        <div class="searchbook ">
            <div class="searchbook_content m5-l-r">
                <h4 class="">Что хотите найти ?</h4>
                <div class="inputsearchbook">
                    <input type="text" class="form-control" id="searchbook" v-model="search" placeholder="поиск книг..."
                        @keyup.enter="setSearch()" />
                    <button class="btn" id="searchbookclick" @click="setSearch()">
                        поиск
                    </button>
                </div>
                <h1 class="m5-l-r name_ganr" style="font-size: 3rem"></h1>
                <div class="book_genres_content">
                    <div class="book_genres_content_item ">
                        <div class="d-flex align-items-center ">
                            <div>
                                <h3 v-if="books.length != 0">Результаты поиска</h3>
                                <h5 class="searcbookText">
                                    По запросу <b>{{ $route.query.query }}</b>, {{ countBook }}.
                                    <img class="not_searchbook_bad" v-if="books.length == 0"
                                        src="../../../static/img/sad.png" />
                                </h5>
                            </div>
                        </div>

                        <div class="books searcbook  ">

                            <Book :item="item" v-for="(item ) in books" :key="item.id" />
                        </div>
                    </div>
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
<style lang='scss' scoped >
main{
    height: 100%;
}
.book_genres_content {
    padding-bottom: 40px;
}

.not_searchbook_bad {
    width: 70px;


}

.searchbook {

    padding-bottom: 70px;

    &_content {

        background: #21231e;
        padding: 20px;
        border-radius: 10px;
        color: white;

        p {
            margin-top: 5px;
            font-size: 1.2rem;
        }

        h3 {
            color: white;
            font-size: 2rem;
        }
    }
}

.searchbook_content .searchbook_content h4 {
    color: white;
}

.searcbook {
    color: rgb(0, 0, 0);
}

.inputsearchbook {
    margin-top: 15px;
    display: flex;
    align-items: center;
    height: 50px;
    overflow: hidden;

    button {
        border: none;
        background: none;
        font-size: 1.1rem;
        cursor: pointer;
        height: 100%;
        border-radius: 0 5px 5px 0;
        background: #e6520e;
        padding: 4px 30px;
        color: white;
        margin: 0;
    }

    input {
        width: 600px;
        height: 100%;
        border-radius: 5px 0 0 5px;
        border: white solid 2px;
        color: white;
        padding: 0 5px;
        background: #ffffff1f;
        transition: 0.4s;

        &::placeholder {
            font-family: 'ml';
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
        }
    }
}
</style>
