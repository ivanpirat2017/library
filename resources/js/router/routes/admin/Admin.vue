<template >
  <div class="container">
    <ul class="nav justify-content-center">
      <li class="nav-item">
        <router-link class="nav-link active" aria-current="page" to="/admin/addbooks">Книги</router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link active" aria-current="page" to="/admin/addaction">Подборка книг</router-link>
      </li>
       <li class="nav-item">
        <router-link class="nav-link active" aria-current="page" to="/admin/editadmin">Одобрения комментов</router-link>
      </li>
       <li class="nav-item">
        <router-link class="nav-link active" aria-current="page" to="/">HOME</router-link>
      </li>

    </ul>
    <router-view></router-view>
  </div>
</template>
<script>
export default {};
</script>
<style lang="scss">
</style>

