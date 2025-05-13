<template>
  <div class="mt-6 bg-red-700 p-6 rounded-3xl shadow w-full">
    <h2 class="text-lg font-bold mb-4 text-white">
      Calon Ibu atau Ibu yang Mendapat Akses Air Minum Layak
    </h2>

    <div class="text-sm mb-2 text-white">
      {{ layak }} dari {{ total }} memiliki akses air minum layak
    </div>

    <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
      <div
        class="bg-green-500 h-6 rounded-full text-white text-sm flex items-center justify-center"
        :style="{ width: percentage + '%' }"
      >
        {{ percentage.toFixed(1) }}%
      </div>
    </div>
  </div>
</template>     

<script lang="ts" setup>
import { ref, onMounted, computed } from 'vue' // ← pastikan computed diimpor
import axios from 'axios'

const total = ref(0)
const layak = ref(0)

const percentage = computed(() =>
  total.value > 0 ? (layak.value / total.value) * 100 : 0
)

onMounted(async () => {
  try {
    const res = await axios.get('/api/akses-air-minum-layak')
    total.value = res.data.total
    layak.value = res.data.layak
  } catch (err) {
    console.error('Gagal mengambil data akses air minum:', err)
  }
})
</script>