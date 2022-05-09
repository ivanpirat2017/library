<template >
  <div class="action" >
    <div>
      <h2 class="actiontitle">{{ item.title_action }}</h2>
      <router-link :to="`/action/${item.id}`" class="btn btn-secondary"
        >подробнее</router-link
      >
    </div>
    <img :src="img" alt="" />
  </div>
</template>
<script>

import fonaction from "../../../static/img/fonaction.jpg";

fonaction.jpg;
export default {
  props: ["item"],
  data() {
    return {
      img:  this.item.img_action ?'/storage/'+this.item.img_action : fonaction
    };
  },
};
</script>
<style lang="scss">
.action {
  height: 100%;
  overflow: hidden;
  margin: 0 5px;
  border-radius: 10px;
  max-width: 300px;
  position: relative;
  scroll-snap-align: start;
  div {
    position: absolute;
    background: rgba(0, 0, 0, 0.5);

    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    pointer-events: none;
    z-index: 2;
    a {
      font-family: "mm";
      height: 20%;
      pointer-events: stroke;
      &:hover {
        color: #ffffff;
        background: #6c757da1;
      }
    }
    h2 {
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      text-shadow: rgba(255, 255, 255, 0.308) 0 0 20px;
      text-align: center;
      font-size: 1.2rem;
      height: 80%;
    }
  }
  img {
    z-index: 1;
    position: relative;
    height: 100%;
    transition: 0.7s;
    &:hover {
      transform: scale(1.2);
    }
  }
}
</style>
