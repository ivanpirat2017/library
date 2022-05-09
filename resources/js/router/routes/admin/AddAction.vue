<template>
  <div class="container">
    <div class="form d-flex flex-column bg-dark p-5">
      <h2>Подборка книг</h2>
      <div class="mb-2">
        <div class="mb-2">
          <label for="exampleFormControlInput1" class="form-label text-light"
            >Поиск книги</label
          >
          <input
            type="text"
            v-model="searchbook"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="поиск книг по жанрам, названию, дате"
            @input="setSearch()"
          />
        </div>
        <label for="exampleFormControlInput1" class="form-label text-light"
          >Выбирите книги для подборок</label
        >
        <select
          class="form-select"
          v-model="setbook"
          aria-label="Default select example"
        >
          <option v-for="(item, index) in books" :key="index" :value="item.id">
            {{ item.title }}
          </option>
        </select>
        <button type="button" class="btn btn-primary" @click="GetBooks()">
          добавить книгу
        </button>
      </div>
      <div class="mb-2">
        <h2>Создать подборку</h2>
        <div class="mb-2">
          <label for="formFile" class="form-label text-light">Обложка </label>
          <input class="form-control" type="file" id="ActionImg" />
        </div>
        <div class="mb-2">
          <label for="exampleFormControlInput1" class="form-label text-light"
            >Назавание
          </label>
          <input
            type="text"
            v-model="title"
            class="form-control"
            id="exampleFormControlInput1"
            placeholder="введите назавание"
          />
        </div>
        <div class="mb-2">
          <label for="exampleFormControlInput1" class="form-label text-light"
            >Описание</label
          >
          <textarea
            type="text"
            v-model="description"
            class="form-control"
            rows="6"
            id="exampleFormControlInput1"
            placeholder="введите Описание"
          />
        </div>
        <button type="button" class="btn btn-primary" @click="creareAction()">
          Создать
        </button>
      </div>
      <div class="mb-2">
        <h2>Выбраные книги</h2>
        <div class="books ">
          <div v-for="(item, id) in apibooks" :key="id">
            <Book :item="item" :key="item.id" />
            <button
              type="button"
              class="btn btn-danger"
              @click="delbook(item.id)"
            >
              Удалить
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Book from "../../../components/items/Book.vue";
import {
  getApi,
  SEARCH_BOOK,
  FAVOURITES,
  CREATE_ACTION,
} from "../../../api-routes";
export default {
  components: {
    Book,
  },
  data() {
    return {
      title: "",
      description: "",
      searchbook: "",
      books: [],
      setbook: "",
      booksId: [],
      apibooks: [],
    };
  },
  methods: {
    delbook(id) {
      this.booksId.splice(this.booksId.indexOf(+id), 1);
      this.apibooks.splice(this.booksId.indexOf(+id), 1);
    },
    async creareAction() {
      const ActionImg = await document.querySelector("#ActionImg");
      const formdata = new FormData();
      await formdata.append("title_action", this.title);
      await formdata.append("description_action", this.description);
      await formdata.append("books_action", JSON.stringify(this.booksId));
      await formdata.append("img_action", ActionImg.files[0]);
      await fetch(CREATE_ACTION, {
        method: "POST",
        body: formdata,
        headers: {
          Accept: "multipart/form-data",
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      }).then((r) => {
        if (r.status == 204) {
          this.title = "";
          this.description = "";
          this.booksId = [];
          this.apibooks = [];
        }
      });
    },
    setSearch() {
      getApi(SEARCH_BOOK + this.searchbook).then((r) => {
        this.books = r.data;
      });
    },
    GetBooks() {
      if (!this.booksId.includes(+this.setbook)) {
        this.booksId.push(this.setbook);
        console.log(this.booksId);
      } else {
        this.booksId.splice(this.booksId.indexOf(+this.setbook), 1);
      }
      const form = new FormData();
      form.append("favouritesId", JSON.stringify(this.booksId));
      getApi(FAVOURITES, {
        method: "POST",
        body: form,
      }).then((r) => {
        this.apibooks = r.data;
      });
    },
  },
};
</script>
<style lang="scss">
</style>
