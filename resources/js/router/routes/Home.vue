<template >
  <Placeholder v-if="loadingBool" />
  <main>
    <div class="caterogies m5-l-r">
      <a href="#">Новинки</a>
      <a href="#">Часто просматриваемое</a>
      <a href="#">Акции</a>
      <a href="#">Бесплатные книги</a>
    </div>

    <Slider class="m5-l-r t-pt-35" />
    <div class="search t-mt-35">
      <div class="search_content m5-l-r">
        <h4 class="t-pt-35">Хотите найти книгу?</h4>
        <div class="inputsearch">
          <input
            type="text"
            class="form-control"
            id="searchbook"
            v-model="search"
            placeholder="поиск книг по жанрам , названию , дате"
            @keyup.enter="$router.push('/search?query=' + search)"
          />
          <button
            class="btn"
            id="searchbookclick"
            @click="$router.push('/search?query=' + search)"

          >
            поиск
          </button>
        </div>
        <h3 class="t-pt-70">Добро пожаловать!</h3>
        <p>
          «Library» – это электронная библиотека.<br />
          А ещё это удобный интернет-магазин. В нём можно заказывать книги
          разных жанров: триллеры и детективы, фэнтези и фантастику, комиксы и
          мангу.<br />
          На сайте есть разделы, в которых легко найти интересные новинки,
          бестселлеры и современную прозу.<br /><br />
          Кроме книг, у нас есть канцтовары, настольные игры, значки, мягкие
          игрушки и ещё много полезного и милого.<br />
          Выбирайте то, что поднимет настроение!
        </p>
      </div>
    </div>
    <h3 class="m5-l-r t-pt-35">Новые книги</h3>
    <div class="books m5-l-r t-pb-35 ">
      <Book :item="item" v-for="(item, id) in books" :key="id" />
    </div>
  </main>
</template>
<script>

import Book from "../../components/items/Book.vue";
import Slider from "../../components/items/Slider.vue";
import { getApi, GET_NEW_BOOKS, GET_ACTION } from "../../api-routes";
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
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getbook();
        });
    },
  },
};
</script>
<style   lang='scss'  >
</style>


