<template >
    <InfoItem :closeInfo="closeInfo" v-if="infopanel" :title="'Коллекция'"
        :textbody="'Вы впервые создали коллекцию, она отображается внизу вашей страницы, при нажатие на неё она раскроется и там будут ваши книги.'" />
    <div>
        <h2 class="m5-l-r p-t-50 name_ganr" v-if="collections.length != 0">
            Ваша коллекция книг
        </h2>
        <h2 class="m5-l-r p-t-50 name_ganr" v-else>Ваша коллекция книг пуста</h2>
        <div v-if="collections.length != 0" class="accordion m5-l-r mb-3 boder-shodow-radius"
            id="accordionPanelsStayOpenExample">
            <div class="accordion-item bg-white" v-for="(collection, i) in collections"
                :key="collection.namecollection + i + collection.id">
                <h2 class="accordion-header" :id="'panelsStayOpen-headingThree' + i">
                    <button class="accordion-button collapsed bg-white" type="button" data-bs-toggle="collapse"
                        :data-bs-target="'#panelsStayOpen-collapseThree' + i" aria-expanded="false"
                        :aria-controls="'panelsStayOpen-collapseThree' + i">
                        <div class="d-flex justify-content-between container-fluid">
                            <h5>{{ collection.namecollection }}</h5>
                            <button type="button" class="btn btn-danger"
                                @click.prevent="dellCollection(collection.id, i)">
                                X
                            </button>
                        </div>
                    </button>
                </h2>
                <div :id="'panelsStayOpen-collapseThree' + i" class="accordion-collapse collapse"
                    :aria-labelledby="'panelsStayOpen-headingThree' + i">
                    <div class="accordion-body books d-flex-wrap">
                        <Book :item="item" :collection="true" v-for="(item, id) in collection.books" :key="id" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Book from "../../components/items/Book.vue";
import InfoItem from "../../components/items/InfoItem.vue";
import {

    GET_COLLECTION,
    DELL_COLLECTION,
} from "../../api-routes";
export default {
    components: {
        Book,
        InfoItem,
    },
    mounted() {
        this.getCollec();
    },
    data() {
        return {
            collections: [],
            infopanel: JSON.parse(localStorage.getItem("infopanelprofile")) ?? null,
        }
    },
    methods: {
        closeInfo() {
            this.infopanel = !this.infopanel;
            localStorage.setItem("infopanelprofile", false);
        },
        getCollec() {
            fetch(GET_COLLECTION, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
                .then((r) => {
                    if (r.status == 200) {
                        return r.json();
                    } else {
                        alert("ошибка на сервере");
                    }
                })
                .then((r) => {
                    this.collections = r.data;

                    if (this.collections.length > 0) {
                        if (this.infopanel == null) {
                            this.infopanel = true;

                        }
                    }
                });
        },
        dellCollection(id) {
            this.collections.splice(i, 1);

            fetch(DELL_COLLECTION + id, {
                method: "GET",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            }).then((r) => {
                if (r.status == 204) {
                    this.getCollec();
                } else {
                    alert("ошибка на сервере");
                }
            });
        },
    }
}
</script>
<style lang="scss">
.name_ganr {
    font-size: 2.2rem;
}
</style>
