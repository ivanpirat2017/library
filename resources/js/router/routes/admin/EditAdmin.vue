<template>
  <div class="container">
    <h2>Комменты</h2>
    <div class="editbtnadmin">
      <button type="button" class="btn btn-success" @click="getcomment('push')">
        Опубликованные
      </button>
      <button type="button" class="btn btn-warning" @click="getcomment('ааа')">
        На рассмотрении
      </button>
      <button type="button" class="btn btn-danger" @click="getcomment('dell')">
        Удаленные
      </button>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Сообщение</th>
          <th scope="col">Автор</th>
          <th scope="col">Одобрить</th>
          <th scope="col">Удалить</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in comments" :key="item.id">
          <th>
            {{ item.message }}
          </th>
          <td>
            <router-link :to="'/user/' + item.user.id">
              {{ item.user.last_name }} {{ item.user.first_name }}</router-link
            >
          </td>
          <td>
            <button
              type="button"
              class="btn btn-success"
              @click="commentUpdata(item.id, 'push')"
            >
              ✓
            </button>
          </td>
          <td>
            <button
              type="button"
              class="btn btn-danger"
              @click="commentUpdata(item.id, 'dell')"
            >
              X
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import { GET_COMMENT_ADMIN, UPDATA_COMMENT_ADMIN } from "../../../api-routes";
export default {
  data() {
    return {
      comments: [],
      cmd: "test",
    };
  },
  mounted() {
    this.getcomment();
  },
  methods: {
    commentUpdata(id, cmd) {
      const form = new FormData();
      form.append("comand", cmd);
      form.append("id", id);
      fetch(UPDATA_COMMENT_ADMIN, {
        method: "POST",
        body: form,
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      }).then((r) => {
        this.getcomment();
      });
    },
    getcomment(cmd = this.cmd) {
      this.cmd = cmd;
      fetch(GET_COMMENT_ADMIN + cmd, {
        method: "GET",
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token"),
        },
      })
        .then((r) => r.json())
        .then((r) => {
          this.comments = r.data;
        });
    },
  },
};
</script>
<style lang="scss">
.editbtnadmin {
  button {
    margin-right: 5px;
  }
}
</style>
