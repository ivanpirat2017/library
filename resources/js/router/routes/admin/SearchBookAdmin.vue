<template>
    <div>
        <div class="container bg-dark">
            <div class="mb-2">
                <label for="exampleFormControlInput1" class="form-label text-light">Поиск книг</label>
                <input type="text" v-model="searchbook" class="form-control" id="exampleFormControlInput1"
                    placeholder="поиск книг по жанрам, названию, дате" @input="setSearch()" />
            </div>
            <table class="table table-dark  bg-dark">
                <thead>
                    <tr>
                        <th scope="col">Назавание</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in books" :key="item.id">
                        <td>{{ item.title }}</td>
                        <td>{{ item.author }}</td>
                        <td>
                            <button type="button" @click="dellbook(item.id)" class="btn btn-danger">
                                Удалить
                            </button>
                        </td>
                        <td>
                            <button type="button" @click="this.$router.push('/admin/bookabout/' + item.id)"
                                class="btn btn-primary">
                                О
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import {getApi,SEARCH_BOOK} from "../../../api-routes";
export default {
    data() {
        return {
            searchbook: "",
            books: [],
        };
    },
    methods: {
        setSearch() {
            getApi(SEARCH_BOOK + this.searchbook).then((r) => {
                this.books = r.data;
            });
        },
    }
}
</script>
<style lang="scss">
</style>


