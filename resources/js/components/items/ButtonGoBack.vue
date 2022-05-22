<template  >
<img src="../../../static/img/logout.png"  @click="$router.back()" class="btn-img-pointer cursorPointer m7-p-b   " height="50" alt="" srcset="" />
</template>
<script>
export default {};
</script>
<style >
.cursorPointer{
    cursor: pointer;
}
.btn-img-pointer{

     filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.096) );
}
</style>
