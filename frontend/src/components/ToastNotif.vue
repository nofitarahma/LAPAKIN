<template>
  <Transition name="toast">
    <div v-if="visible" class="toast" :class="`toast-${type}`">
      {{ message }}
    </div>
  </Transition>
</template>

<script setup>
defineProps({ message: String, type: String, visible: Boolean })
</script>

<style scoped>
.toast {
  position: fixed;
  bottom: 32px;
  right: 32px;
  z-index: 999;
  padding: 14px 22px;
  border-radius: 14px;
  font-size: 14px;
  font-weight: 700;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.toast-success { background: var(--c1); color: var(--c3); }
.toast-error   { background: #dc2626; color: #fff; }
.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateY(16px); }
</style>
