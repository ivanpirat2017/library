<template  >
  <Placeholder v-if="loadingBool" />
  <InfoItem
    :closeInfo="closeInfo"
    v-if="!infopanel"
    :title="'Здравствуйте, вы у нас в первые раз? '"
    :textbody="'В этом разделе вы можете скачать книгу, оставить отзыв, вести диалоги о книги - в чате, а также просмотреть карточку пользователя (нажав на его аватарку). Удачного времяпровождения! '"
    :textbody2="' P.s некоторые возможности сайта, доступны только авторизированным пользователем.'"
  />
  <main class="m5-l-r">
    <ButtonGoBack />
    <h2 style="font-size: 36px" class="m5-p-b title">{{ bookinfo.title }}</h2>
    <div class="adout_book">
      <div class="adout_book_img">
        <img :src="img" class="book_img_title" alt="" />
      </div>
      <div class="adout_book_content">
        <p class="genre">Жанр книги: {{ bookinfo.genrename }}</p>
        <p class="reting">
          Рейтинг: <span>{{ bookinfo.reting }}/5</span>
        </p>
        <p class="author">Автор книги: {{ bookinfo.author }}</p>
        <p class="date">Дата написания: {{ bookinfo.release }}</p>
        <p class="status">Статус книги: {{ bookinfo.status }}</p>
        <p class="status">Книгу просмотрели : {{ watchbook }} раз</p>
        <button class="book_button_grean btn" @click="download()">
          скачать
        </button>
        <img
          :src="startext"
          alt=""
          height="30"
          @click="btnclickstar()"
          class="FavoritesImg"
        />
        <p>
          Чат (alpha)
          <router-link :to="'/chatbook/' + bookId">открыть</router-link>
        </p>
      </div>
    </div>
    <div class="adout_book_text">
      <h2 class="m5-p-b">Описание книги</h2>
      <p class="description">{{ bookinfo.description }}</p>
    </div>
    <h2 class="m5-p-b" v-if="boolComments">Написать комментарий</h2>
    <div class="alert alert-info" role="alert" v-if="update">
      Комментарий находится на рассмотрении
    </div>
    <div class="alert alert-danger" role="alert" v-if="errr">
      Введите более 10 символов
    </div>
    <div class="adout_book_text_edit" v-if="boolComments">
      <div class="adout_book_text_edit_content">
        <div contenteditable class="editcomment"></div>
        <button
          class="book_button_grean btn_send btn"
          id="btnaddcomment"
          @click="setComment()"
        >
          <img src="../../../static/img/send.png" tabindex="0" alt="" />
        </button>
      </div>
    </div>
    <h2 class="m5-p-b">Комментарий к книге</h2>
    <div class="adout_book_comments">
      <div v-if="comments.length == 0">
        <h3>Список комментариев пуст</h3>
      </div>

      <Message :item="item" v-for="item in comments" :key="item.id" />
    </div>
  </main>
</template>
<script>
import {
  getApi,
  GET_GENRE_BOOK_ID,
  GET_COMMENT_BOOK_ID,
  ADD_COMMENT,
  authCheck,
  ADD_WATCH_BOOK,
  DOUMLONDDOOK,
} from "../../api-routes";
import Message from "../../components/items/Bookadout/Message.vue";
import InfoItem from "../../components/items/InfoItem.vue";
import Placeholder from "../../components/items/Placeholder.vue";
import ButtonGoBack from "../../components/items/ButtonGoBack.vue";
import imagebook from "../../../static/img/bookimg.png";
import Favorites from "../../../static/img/favorites.png";
import FavoritesFull from "../../../static/img/favorites-full.png";
export default {
  components: {
    Message,
    Placeholder,
    InfoItem,
    ButtonGoBack,
  },
  beforeUnmount() {
    clearInterval(this.timeComent);
  },

  data() {
    return {
      cartArrId: JSON.parse(localStorage.getItem("cartid")) ?? [],
      bookinfo: {},
      comments: [],
      watchbook: 0,
      textcomet: "",
      bookGanre: this.$route.params.ganre,
      bookId: this.$route.params.id,
      startext: null,
      img: "",
      timeComent: null,
      loadingBool: true,
      update: false,
      errr: false,
      boolComments: false,
      infopanel: localStorage.getItem("infopanel"),
    };
  },
  mounted() {
    this.addwatchbook(+this.bookId);
    if (this.cartArrId.includes(+this.bookId)) {
      this.startext = FavoritesFull;
    } else {
      this.startext = Favorites;
    }
    authCheck().then((r) => {
      if (r.status != 200) {
        this.boolComments = false;
      }
      if (r.status == 200) {
        this.boolComments = true;
      }
    });
    this.timeComent = setInterval(() => {
      this.getcomment();
    }, 5000);

    this.getcomment();
    getApi(GET_GENRE_BOOK_ID + this.bookGanre + "/" + this.bookId).then((r) => {
      this.bookinfo = r.data;
      this.loadingBool = false;
      this.img = this.bookinfo.bookimg
        ? "/storage/" + this.bookinfo.bookimg
        : imagebook;

      this.watchbook = r.watch;
    });
  },
  methods: {
    closeInfo() {
      this.infopanel = !this.infopanel;
      localStorage.setItem("infopanel", true);
    },
    download() {
      window.open(DOUMLONDDOOK + +this.bookId, "_blank");
    },
    addwatchbook(id) {
      fetch(ADD_WATCH_BOOK + id, {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      });
    },
    setComment() {
      const editcomment = document.querySelector(".editcomment");
      const form = new FormData();
      form.append("message", editcomment.textContent);
      form.append("book_comment_id", this.bookId);
      if (editcomment.textContent.length < 10) {
        this.errr = true;
        setTimeout(() => {
          this.errr = false;
        }, 3000);
      } else {
        fetch(ADD_COMMENT, {
          method: "POST",
          body: form,
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        }).then((r) => {
          editcomment.textContent = "";
          this.getcomment();
          this.update = true;
          setTimeout(() => {
            this.update = false;
          }, 3000);
        });
      }
    },
    getcomment() {
      getApi(GET_COMMENT_BOOK_ID + this.bookId).then((r) => {
        this.comments = r.data;
      });
    },
    btnclickstar() {
      if (!this.cartArrId.includes(+this.bookId)) {
        this.cartArrId.push(+this.bookId);
        this.startext = FavoritesFull;
      } else {
        this.cartArrId.splice(this.cartArrId.indexOf(+this.bookId), 1);
        this.startext = Favorites;
      }
      this.$root.cartArrId = this.cartArrId;
      localStorage.setItem("cartid", JSON.stringify(this.cartArrId));
    },
  },
};
</script>
<style  lang='scss'>
.logo_user {
  display: flex;
  flex-shrink: 0;
  justify-content: center;
  align-items: center;
  width: 90px;
  height: 90px;
  overflow: hidden;
  border-radius: 100%;
  margin-right: 10px;
  @media (max-width: 1200px) {
    width: 60px;
    height: 60px;
    margin-right: 10px;
  }
  a {
    width: 100%;
    height: 100%;
    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
}

.adout_book {
  display: flex;
  flex-direction: row;
  gap: 20px;
  @media (max-width: 700px) {
    flex-direction: column;
  }
  &_comments {
    padding: 20px 0;
  }
  &_comment {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    &_img {
      display: flex;
      background-color: rgb(240, 240, 240);
      padding: 10px;
      border-radius: 10px;
      border: #ffffff 3px solid;
      box-shadow: rgba(1, 0, 61, 0.301) 0 10px 20px;
      margin-bottom: 30px;
      img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    }
    &_content {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      flex-direction: row;
      p {
        width: 98%;
        @media (max-width: 1200px) {
          width: 95%;
        }
      }
      div {
        font-size: 1rem;
        margin-left: 5px;
        width: 65px;
        text-align: end;
        cursor: pointer;
      }
    }
  }

  &_text {
    padding-bottom: 25px;
    border-bottom: #0c2d0c 2px solid;
    &_edit {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      padding-bottom: 25px;
      &_content {
        display: flex;
        width: 100%;
        align-items: flex-end;
        &_like_on {
          color: rgb(145, 28, 255);
        }
        &_like_off {
          color: rgb(255, 28, 28);
        }
        &_like_dell {
          color: rgb(22, 18, 37);
        }
      }
    }
  }
  &_content {
    p {
      margin-bottom: 15px;
      font-family: "mr";
      font-size: 1.2rem;
      span {
        color: rgb(255, 99, 9);
        font-size: 1.3rem;
        @media (max-width: 800px) {
          font-size: 1.4rem;
        }
        font-family: "mb";
      }
    }
  }
  &_img {
    height: 500px;

    @media (max-width: 700px) {
      width: 80%;
      height: auto;
    }
    img {
      width: 100%;
      border-radius: 10px;
      box-shadow: rgba(0, 0, 0, 0.137) 0 10px 20px;
    }
  }
}
.editcomment {
  width: 100%;
  padding: 6px;
  border-radius: 5px;
  margin-right: 10px;
  border: #1e5945 3px solid;
  &:focus {
    outline: none;
  }
}
</style>
