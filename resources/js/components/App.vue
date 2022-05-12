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
        //this.$store.getters.getprofile.first_name;
        this.$store.dispatch('GET_API_AWARDS');
        this.cartArrId = JSON.parse(localStorage.getItem("cartid"))
            ? JSON.parse(localStorage.getItem("cartid"))
            : [];
    },
};
</script>

<style >
</style>
