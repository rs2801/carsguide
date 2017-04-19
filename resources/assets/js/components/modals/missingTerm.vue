<template>
    
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-body">
            <slot name="body">
              <p>Search term is required.  For example to search for carsguide enter "carsguide".</p>

              <p>If you would like to search for a hashtag enter "#carsguide"</p>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button class="modal-default-button" v-on:click="$emit('close')">Got it</button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>

</template>

<script>
    export default {
    }
</script>
