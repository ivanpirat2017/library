<template  >
  <div class="modalInfo">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">
            {{ title }}
          </h3>
        </div>
        <div class=" modalInfomodal-body modal-body">
         <h5>{{textbody}}</h5>
          <br>
          <p>{{textbody2}}</p>
        </div>
        <div class="modal-footer">
          <button @click="closeInfo()" type="button" class="btn btn-secondary">
            Закрыть
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["closeInfo", "title", "textbody",'textbody2'],
};
</script>
<style lang="scss">
.modalInfo {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-items: center;
  background: rgba(0, 0, 0, 0.5);
  z-index: 3;
  &modal-body {
      p{
          color: red;
          font-family: 'mm';
      }
  }
}
</style>

