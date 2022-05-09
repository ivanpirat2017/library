<template>
<router-view></router-view>
</template>

<script>
export default {
  data() {
    return {
      cartArrId: [],
    };
  },
  mounted() {
    this.cartArrId = JSON.parse(localStorage.getItem("cartid"))
      ? JSON.parse(localStorage.getItem("cartid"))
      : [];
  },
};
</script>

<style >

</style>
