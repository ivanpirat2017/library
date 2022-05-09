<template >
  <Placeholder v-if="loadingBool" />
  <main>
    <h2 style="font-size: 36px" class="m5-l-r t-pt-35">Жанры</h2>
    <div class="caterogies m5-l-r">
      <a
        @click="$router.push('/booksganre/' + item.genre)"
        v-for="item in genres"
        :key="item.genre"
        >{{ item.genrename }}</a
      >
    </div>
    <Slider class="m5-l-r t-pt-35" />
    <h1 class="m5-l-r t-pt-35 name_ganr" style="font-size: 3rem"></h1>
    <div class="book_genres_content">
      <div class="book_genres_content_item m5-l-r">
        <h3 class="t-pt-35">Популярные</h3>
        <div class="books popular">
          <Book :item="item" v-for="(item, id) in getpopularbooks" :key="id" />
        </div>
      </div>
      <div class="book_genres_content_item m5-l-r">
        <h3 class="t-pt-35">Новые</h3>
        <div class="books booksnew">
          <Book :item="item" v-for="(item, id) in getnewbooks" :key="id" />
        </div>
      </div>
    </div>
  </main>
</template>
<script>
import Placeholder from "../../components/items/Placeholder.vue";
import Slider from "../../components/items/Slider.vue";
import {
  getApi,
  GET_ALL_GENRES,
  GET_NEW_BOOKS,
  GET_POPULAR_BOOKS,
  GET_ACTION,
} from "../../api-routes";
import Book from "../../components/items/Book.vue";
export default {
  components: {
    Book,
    Placeholder,
    Slider,
  },
  data() {
    return {
      genres: [],
      getpopularbooks: [],
      getnewbooks: [],
      actions: [],
      loadingBool: true,
    };
  },
  methods: {
    getGENRES() {
      getApi(GET_ALL_GENRES)
        .then((r) => {
          this.genres = r.data;
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getGENRES();
        });
    },
    getPOPULAR_BOOKS() {
      getApi(GET_NEW_BOOKS)
        .then((r) => {
          this.getnewbooks = r.data;
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getPOPULAR_BOOKS();
        });
    },
    getNEW_BOOKS() {
      getApi(GET_POPULAR_BOOKS)
        .then((r) => {
          this.getpopularbooks = r.data;
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getNEW_BOOKS();
        });
    },
    getACTION() {
      getApi(GET_ACTION)
        .then((r) => {
          this.actions = r.data;
          this.loadingBool = false;
        })
        .catch((r) => {
          this.getACTION();
        });
    },
  },
  mounted() {
    this.getNEW_BOOKS();
    this.getPOPULAR_BOOKS();
    this.getACTION();
    this.getGENRES();
  },
};
</script>
<style  >
</style>
