<template >
</template>
<script>
import {TOKEN_UPDATE} from '../../api-routes'
export default {
    mounted() {
        localStorage.setItem('token', this.$route.params.id)
        const form = new FormData();
        form.append("api_token", this.$route.params.id);
        form.append("browser", navigator.userAgent.toLowerCase());
        fetch(TOKEN_UPDATE, {
            method: 'POST',
            body: form
        })
        this.$router.push('/profile')
    }
}
</script>
