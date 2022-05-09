<template >
  <Placeholder v-if="loadingBool" />
  <main>
    <ButtonGoBack class="m5-l-r" />
    <h2 class="m5-l-r t-pt-35 name_ganr" style="font-size: 36px">
      {{ genre }}
    </h2>
    <div class="book_genres_content" v-if="!books.length == 0">
      <div class="book_genres_content_item m5-l-r">
        <div class="books">
          <Book :item="item" v-for="item in books" :key="item.id" />
        </div>
        <div class="d-flex justify-content-center pt-5">
          <nav aria-label="Page navigation example  ">
            <ul class="pagination">
              <li class="page-item">
                <a
                  class="page-link"
                  @click="
                    clikc(-1);
                    getBooks(sumckick);
                  "
                >
                  <span aria-hidden="true">&laquo;</span></a
                >
              </li>
              <li class="page-item" :class="{ active: sumckick == 1 }">
                <a class="page-link"  @click="
                    clikcall(1);
                    getBooks(sumckick);">1</a>
              </li>
              <li
                class="page-item"
                v-if="databook.last_page > 4 && sumckick > 1"
              >
                <a class="page-link">...</a>
              </li>
              <li
                class="page-item"
                v-if="
                  databook.last_page > 2 &&
                  sumckick > 1 &&
                  sumckick < databook.last_page
                "
                :class="{ active: true }"
              >
                <a class="page-link">{{ sumckick }}</a>
              </li>
              <li
                class="page-item"
                v-if="databook.last_page > 4 && sumckick < databook.last_page"
              >
                <a class="page-link">...</a>
              </li>
              <li
                class="page-item"
                :class="{ active: databook.last_page == sumckick }"
              >
                <a
                  class="page-link"
                  v-if="databook.last_page > 1"
                    @click="
                    clikcall(databook.last_page);
                    getBooks(sumckick);"
                  >{{ databook.last_page }}</a
                >
              </li>
              <li class="page-item">
                <a
                  class="page-link"
                  @click="
                    clikc(1);
                    getBooks(sumckick);
                  "
                >
                  <span aria-hidden="true">&raquo;</span></a
                >
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
    <h2 class="m5-l-r t-pt-35 name_ganr" v-else style="font-size: 26px">
      увы книг нет :(
    </h2>
  </main>
</template>
<script>
import { getApi, GET_GENRE_BOOKS, GET_GENRE } from "../../api-routes";
import Book from "../../components/items/Book.vue";
import Placeholder from "../../components/items/Placeholder.vue";
import ButtonGoBack from "../../components/items/ButtonGoBack.vue";
export default {
  components: {
    Book,
    Placeholder,
    ButtonGoBack,
  },
  data() {
    return {
      genre: "",
      books: [],
      databook: {},
      loadingBool: true,
      sumckick: 1,
    };
  },
  methods: {
    clikc(i) {
      this.sumckick = this.sumckick + i;
      if (this.sumckick == 0) {
        this.sumckick = 1;
      } else if (this.sumckick == +this.databook.last_page + 1) {
        this.sumckick = +this.databook.last_page;
      }
    },
    clikcall(i) {
      this.sumckick =  i
    },
    getBooks(i) {
      getApi(GET_GENRE_BOOKS + this.$route.params.ganre + "?page=" + i)
        .then((r) => {
          this.books = r.data.data;
          this.databook = r.data;
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getBooks(i);
        });
    },
    getGENRE() {
      getApi(GET_GENRE + this.$route.params.ganre).then((r) => {
        this.genre = r.data.genrename;
      });
    },
  },
  mounted() {
    this.getBooks();
    this.getGENRE();
  },
};
</script>
<style  >
</style>
