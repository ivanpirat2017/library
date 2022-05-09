<template  >
  <button
    type="button"
    class="btn book_button_grean m-r-b"
    data-bs-toggle="modal"
    data-bs-target="#exampleModal"
  >
    Создать коллекцию книг?
  </button>
  <div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Создать коллекцию книг?
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Закрыть"
            @click="df()"
          ></button>
        </div>
        <div class="modal-body">
          <div
            class="alert alert-danger d-flex align-items-center"
            v-if="errr"
            role="alert"
          >
            <div>Введите от 3 до 24 символов , вы ввели {{inputTeext.length}}</div>
          </div>
          <div
            class="alert alert-danger d-flex align-items-center"
            v-if="erlogin"
            role="alert"
          >
            <div>Войдите или зарегистрируйтесь</div>
          </div>
          <div v-if="success" class="alert alert-success" role="alert">
            Коллекция сохранилась в вашей личном кабинете
          </div>
          Введите название коллекции
          <input
            type="text"
            class="form-control bg-light black"
            v-model="inputTeext"
            aria-label="Имя пользователя"
          />
        </div>
        <div class="modal-footer">
          <button
            @click="df()"
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            Закрыть
          </button>
          <button
            type="button"
            class="btn book_button_grean"
            v-if="btnBool"
            @click="setCart()"
          >
            Сохранить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { CREATR_COLLECTION } from "../../api-routes";
export default {
  props: ["dell"],
  data() {
    return {
      inputTeext: "",
      btnBool: true,
      errr: false,
      success: false,
      erlogin: false,
      fetchPush: false,
    };
  },
  methods: {
    df() {
      if (this.fetchPush) {
        (this.btnBool = true), (this.errr = false);
        this.inputTeext = "";
        this.erlogin = false;
        this.success = false;
        this.fetchPush = false;
        this.dell();
      }
    },
    setCart() {
      if (this.inputTeext.length < 3 || this.inputTeext.length > 24) {
        this.errr = true;
      } else {
        const form = new FormData();
        form.append("booksarr", localStorage.getItem("cartid"));
        form.append("namecollection", this.inputTeext);
        fetch(CREATR_COLLECTION, {
          method: "POST",
          body: form,
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        }).then((r) => {
          if (r.status == 204) {
            this.btnBool = false;
            this.errr = false;
            this.success = true;
            this.fetchPush = true;
 
          } else {
            this.erlogin = true;
          }
        });
      }
    },
  },
};
</script>
