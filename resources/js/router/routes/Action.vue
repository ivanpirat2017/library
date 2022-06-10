<template  >
    <Placeholder v-if="loadingBool" />
    <main class="m5-l-r cardconteiner">
        <div class="card mb-3">
            <div class="cartimg">
                <img :src="img" alt="" id="Actionimg" />
            </div>
            <div class="card-body">
                <h2 style="font-size: 36px" class="card-title">
                    {{ action.title_action }}
                </h2>
                <p class="card-text">
                    {{ action.description_action }}
                </p>
                <h3 class="pt-2">Подборка</h3>
                <div class="books">
                    <Book :item="item" v-for="(item, id) in action.books" :key="id" />
                </div>
                <p class="card-text">
                    <small class="text-muted">Последнее обновление {{ datatime }}</small>
                </p>
            </div>
        </div>
    </main>
</template>
<script>
import { getApi, GET_ACTION_ID } from "../../api-routes";
import fonaction from "../../../static/img/fonaction.jpg";
 
import Book from "../../components/items/Book.vue";
import Placeholder from "../../components/items/Placeholder.vue";
export default {
    components: {
        Book,
        Placeholder,
    },
    data() {
        return {
            action: {},
            img: null,
            datatime: null,
            loadingBool: true,
        };
    },
    mounted() {
        getApi(GET_ACTION_ID + this.$route.params.id).then((r) => {
            this.action = r.data;
            this.img = this.action.img_action
                ? "/storage/" + this.action.img_action
                : fonaction;
            this.datatime = new Date(this.action.updated_at).toDateString();
            document.getElementById("Actionimg").onload = () => {
                this.loadingBool = false;
            };
        });
    },
};
</script>
<style lang="scss">
.cardconteiner {

    @media (max-width: 450px) {
        margin: 0;
    }
}

.cartimg {
    max-height: 400px;
    overflow: hidden;

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}
</style>
