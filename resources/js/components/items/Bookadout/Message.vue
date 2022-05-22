<template  >
    <div class="adout_book_comment_img">
        <div class="logo_user">
            <router-link :to="'/user/' + item.user.id"><img :src="image" alt="" /></router-link>
        </div>
        <div class="adout_book_comment">
            <h5>{{ item.user.first_name }} {{ item.user.last_name }}</h5>
            <div class="adout_book_comment_content">

                <p>{{ item.message }}</p>
                <div :class="clickingLike" :key="item.id" @click.prevent="likeClick()">
                    <div class="commentlikeinfo tooltip   fade tooltip-top bs-tooltip-start " :class="infolike">
                        <div class="tooltip-arrow"></div>
                        вы не авторизованы
                    </div>
                    ❤{{ sumlike }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
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
            boollike: false
        };
    },
    methods: {
        likeClick() {

            if (!this.$store.getters.getpauth) {
                this.boollike = !this.boollike
                setTimeout(()=>{
                      this.boollike = false
                },3000)
                return 0;
            }
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
        infolike() {
            return (!this.$store.getters.getpauth && this.boollike) ? 'show' : ''
        },
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
<style lang="scss" scoped>
.commentlikeinfo {
    position: absolute;
    background: #000;
    z-index: 1;
    left: -180px;
    padding: 2px;
    height: 40px;
    width: 200px;
    top: -8px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    border-radius: 5px;

    div {
        right: -7px;
        border-width: 0.4rem;
        border-color: rgb(0, 0, 0);
    }
}
</style>
