<template>
    <InfoItem :closeInfo="newUserBookfaloverClose" v-if="newUserBookfalover" :title="'Здравствуйте!'"
        :textbody="' Все отмеченные книги, будут находиться на странице избранное'" :textbody2="''" />
    <div class="Book">
        <div>
            <div class="BookImg">
                <img :src="img" :key="item.id" />
            </div>
            <h4>{{ item.title }}</h4>
        </div>

        <div class="BookCnt">
            <p>{{ item.genrename }}</p>
            <button class="btn book_button_grean" @click="$router.push('/Bookadout/' + item.genre + '/' + item.id)">
                Открыть
            </button>
            <img :src="startext" alt="" height="30" @click="btnclickstar()" v-if="!collection" class="FavoritesImg" />
            <h4>Рейтинг {{ item.reting }}/5</h4>
        </div>
    </div>
</template>
<script>
import Bookimg from "../../../static/img/bookimg.png";
import Favorites from "../../../static/img/favorites.png";
import FavoritesFull from "../../../static/img/favorites-full.png";
import InfoItem from "./InfoItem.vue";
export default {
    components: {
        InfoItem,
    },
    props: ["item", "collection"],
    mounted() { },
    data() {
        return {
            cartArrId: this.$root.cartArrId,
            img: this.item.bookimg ? "/storage/" + this.item.bookimg : Bookimg,
            newUserBookfalover:
                JSON.parse(localStorage.getItem("newUserBookfalover1")) ?? null,
        };
    },
    methods: {
        newUserBookfaloverClose() {
            this.newUserBookfalover = !this.newUserBookfalover;
            localStorage.setItem("newUserBookfalover1", false);
        },
        btnclickstar() {
            if (!this.cartArrId.includes(this.item.id)) {
                this.cartArrId.push(this.item.id);

                if (JSON.parse(localStorage.getItem("newUserBookfalover1")) == null) {
                    this.newUserBookfalover = true;
                }
            } else {
                this.cartArrId.splice(this.cartArrId.indexOf(this.item.id), 1);
            }
            this.$root.cartArrId = this.cartArrId;
            localStorage.setItem("cartid", JSON.stringify(this.cartArrId));
        },
    },
    computed: {
        startext() {
            return this.cartArrId.includes(this.item.id) ? FavoritesFull : Favorites;
        },
    },
};
</script>
<style  lang="scss" >
.Book {
    &Cnt {
        position: relative;

        &infopup {
            position: absolute;
            background: #1e5945;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.26);
            border-radius: 10px;
            display: flex;
            gap: 10px;
            padding: 10px;
            z-index: 4;

            img {
                width: 30px;
                height: 30px;
            }

            h5 {
                color: white;
                font-size: "mm";
                font-size: 1rem;

                a {
                    color: #ffaf38;
                    font-size: "mb";
                    font-size: 1.2rem;
                }
            }
        }
    }

    &Img {
        overflow: hidden;
        border-radius: 10px;
        width: 100%;
        height: 200px;
        margin: 5px 0;

        img {
            width: 100%;
            object-fit: cover;
        }

        @media (max-width: 1200px) {
            width: 100%;
            height: 150px;
        }

        @media (max-width: 450px) {
            height: 120px;
        }
    }

    flex: 1 1 250px;

    @media (max-width: 1200px) {
        flex: 1 1 200px;
    }

    @media (max-width: 450px) {
        flex: 1 1 150px;
    }

    display: flex;
    justify-content: space-between;
    flex-direction: column;
    overflow: hidden;
    border-radius: 10px;
    padding: 10px;
    max-width: 300px;
    background-color: rgb(250, 250, 250);
    box-shadow: rgba(0, 0, 0, 0.192) 0 0 25px;

    p {
        font-size: 0.8rem;
        margin: 2px 0;
    }

    div {
        h4 {
            margin-top: 0.5rem;
          margin-bottom:0;
            @media (max-width: 450px) {
                font-size: 0.9rem;
            }
        }
    }
}

button {
    outline: none;
    border: none;
}

.FavoritesImg {
    opacity: 0.85;
    margin-left: 5px;
    cursor: pointer;
}
</style>
