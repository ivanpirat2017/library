<template >
</template>
<script>
export default {
    mounted() {
        localStorage.setItem('token', this.$route.params.id)
        this.$router.push('/profile')
    }
}
</script>
