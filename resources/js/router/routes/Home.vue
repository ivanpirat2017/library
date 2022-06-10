<template >
    <Placeholder v-if="loadingBool" />
    <main>
        <Slider class="m5-l-r t-pt-35" />
        <div class="search t-mt-35">
            <div class="search_content m5-l-r">
                <h4 class="t-pt-35">Хотите найти книгу?</h4>
                <div class="inputsearch">
                    <input type="text" class="form-control" id="searchbook" v-model="search"
                        placeholder="поиск книг по жанрам , названию , дате"
                        @keyup.enter="$router.push('/search?query=' + search)" />
                    <button class="btn" id="searchbookclick" @click="$router.push('/search?query=' + search)">
                        поиск
                    </button>
                </div>
                <h3 class="t-pt-70">Приветствуем Вас!</h3>
                <p>
                    На сайте представлены книги разных жанров для бесплатного скачивания.
                    Для удобства пользования библиотекой, есть разделы, в которых легко найти интересные новинки,
                    бестселлеры и современную прозу. Вы можете читать фрагменты книг прямо на сайте, не загружая к себе
                    на компьютер.
                    <br>
                    У каждой книги есть рейтинг, а также отзывы, опубликованные читателями библиотеки. Надеемся, Вы
                    сможете найти что-то интересное для себя!
                </p>
            </div>
        </div>
        <h3 class="m5-l-r t-pt-35">Интересные книги</h3>
        <div class="books m5-l-r t-pb-35 ">
            <Book :item="item" v-for="(item, id) in books" :key="id" />
        </div>
    </main>
</template>
<script>

import Book from "../../components/items/Book.vue";
import Slider from "../../components/items/Slider.vue";
import { imglouder } from "../../script/imglouder";
import { getApi, GET_NEW_BOOKS } from "../../api-routes";
import Placeholder from "../../components/items/Placeholder.vue";
export default {
    components: {
        Book,
        Placeholder,
        Slider,
    },
    data() {
        return {
            books: [],
            search: "",
            loadingBool: true,

        };
    },
    mounted() {
        this.getbook();
    },
    methods: {
        getbook() {
            getApi(GET_NEW_BOOKS)
                .then((r) => {
                    this.books = r.data;
                })
                .catch((r) => {
                    this.getbook();
                }).finally(r => { this.loadingBool = !imglouder() });
        },
    },
};
</script>
<style   lang='scss'  >
</style>


