<template >
  <Placeholder v-if="loadingBool" />
  <main>
    <div class="book_genres_content">
      <div class="book_genres_content_item m5-l-r">
        <ButtonGoBack />
        <h2 style="font-size: 36px" class="t-pt-35">Избранные книги</h2>
        <div class="books bookfavourite"    @click="getBook()">
          <Book
            :item="item"
            v-for=" item   in books"
            :key="item.id"
          />
        </div>
        <h2 class="t-pt-35 infofavourite">{{ countBook }}</h2>
        <img
          class="not_search_bad"
          v-if="books.length == 0"
          src="../../../static/img/sad.png"
          alt=""
          srcset=""
        />
        <InformativeWindow :dell="dellCart" v-if="books.length > 1" />
        <button
          v-if="books.length > 0"
          type="button"
          @click="dellCart()"
          class="btn btn-danger m-r-b"
        >
          Очистить список книг
        </button>
        <h2
          class="t-pt-35 infofavourite"
          v-if="books.length < 2 && books.length > 0"
        >
          Для создании коллекции нужно больше 1 книги
        </h2>
      </div>
    </div>
  </main>
</template>
<script>
import Placeholder from "../../components/items/Placeholder.vue";
import { getApi, FAVOURITES } from "../../api-routes";
import Book from "../../components/items/Book.vue";
import InformativeWindow from "../../components/items/InformativeWindow.vue";
import ButtonGoBack from "../../components/items/ButtonGoBack.vue";
export default {
  components: {
    Book,
    Placeholder,
    InformativeWindow,
    ButtonGoBack,
  },
  data() {
    return {
      books: [],
      loadingBool: true,
    };
  },
  mounted() {
    this.getBook();
  },
  computed: {
    countBook() {
      if (this.books.length == 0) {
        return "Список избранных книг пуст";
      } else if (this.books.length == 1) {
        return this.books.length + " книга";
      } else if (this.books.length < 5) {
        return this.books.length + " книги";
      } else if (this.books.length > 4) {
        return this.books.length + " книг";
      }
    },
  },

  methods: {
    dellCart() {
      localStorage.setItem("cartid", JSON.stringify([]));
      this.$root.cartArrId = [];
      this.getBook();
    },
    getBook() {
      const form = new FormData();
      form.append(
        "favouritesId",
        localStorage.getItem("cartid") ?? JSON.stringify([])
      );
      getApi(FAVOURITES, {
        method: "POST",
        body: form,
      }).then((r) => {
        this.books = r.data;
        this.loadingBool = false;
      });
    },
  },
};
</script>
<style   scoped>
</style>

