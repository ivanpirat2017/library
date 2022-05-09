<template>
  <div class="" :class="boolAuthor2">
    <div class="ChatBookmesegesMesege" :class="boolAuthor">
      <div class="ChatBookmesegesMesegeinfo">
        <h3>{{ item.last_name }} {{ item.first_name }}</h3>
        <!-- <h3>19:00</h3> -->
      </div>
      <p>{{ item.messages }}</p>
    </div>
  </div>
</template>
<script>
export default {
  props: ["item", "author"],
  computed: {
    boolAuthor() {
      if (this.item.id == this.author) {
        return "rmesege";
      }
      return "lmesege";
    },
    boolAuthor2() {
      if (this.item.id == this.author) {
        return "ChatBookmesegesMesege-right";
      }
      return "ChatBookmesegesMesege-left";
    },
  },
};
</script>
<style lang="scss">
.ChatBookmesegesMesege-right{
    display: flex;
    width: 100%;
    justify-content: flex-end;
}
.ChatBookmesegesMesege-left{
    display: flex;
    width: 100%;
    justify-content: flex-start;
}
</style>
