<template>
    <div v-if="show" class="modal-backdrop" @click.self="emit('update:show', false)">
      <div class="modal-content">
        <slot />
      </div>
    </div>
  </template>

  <script lang="ts" setup>
  defineProps<{
    show: boolean;
  }>();

  const emit = defineEmits(['update:show']);
  </script>

  <style scoped>
  .modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
  }
  .modal-content {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
  }
  </style>

<template>
    <div v-if="show" class="modal-backdrop" @click.self="emit('update:show', false)">
      <div class="modal-content">
        <slot />
      </div>
    </div>
  </template>

  <script lang="ts" setup>
  defineProps<{
    show: boolean;
  }>();

  const emit = defineEmits(['update:show']);
  </script>

  <style scoped>
  .modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
  }
  .modal-content {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
  }
  </style>