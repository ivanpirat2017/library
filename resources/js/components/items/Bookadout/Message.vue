<template  >
  <div class="adout_book_comment_img">
    <div class="logo_user">
      <router-link :to="'/user/' + item.user.id"
        ><img :src="image" alt=""
      /></router-link>
    </div>
    <div class="adout_book_comment">
      <h5>{{ item.user.first_name }} {{ item.user.last_name }}</h5>
      <div class="adout_book_comment_content">
        <p>{{ item.message }}</p>
        <div :class="clickingLike" :key="item.id" @click.prevent="likeClick()">
          ❤{{ sumlike }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Imgauto } from "../../../script/imgauto";
import { LIKE_COMENT } from "../../../api-routes";
import imagelogo from "../../../../static/img/ava.jpg";
export default {
  props: ["item"],
  data() {
    return {
      image: this.item.user.avatar
        ? "/storage/" + this.item.user.avatar
        : imagelogo,
      likedata: "",
      sumlike: this.item.sum_like,
    };
  },
  methods: {
    likeClick() {
      const formlike = new FormData();
      formlike.append("like_comment_id", this.item.id);
      fetch(LIKE_COMENT, {
        method: "POST",
        body: formlike,
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      })
        .then((t) => t.json())
        .then((r) => {
          if (r.data == true) {
            this.likedata = "push";
            this.sumlike++;
          } else if (r.data == false) {
            this.likedata = "del";
            this.sumlike--;
          }
        });
    },
  },
  computed: {
    clickingLike() {
      if (this.likedata == "del") {
        return "adout_book_text_edit_content_like_dell";
      } else if (this.likedata == "push") {
        return "adout_book_text_edit_content_like_on";
      }
      return "adout_book_text_edit_content_like_off";
    },
  },
};
</script>
<style>
</style>
