<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const total = ref(0)
const lebihDari2 = ref(0)

onMounted(async () => {
  try {
    const res = await axios.get('/api/statistik/ibu-anak-lebih-2')
    total.value = res.data.total
    lebihDari2.value = res.data.lebih_dari_2
  } catch (e) {
    console.error('Gagal memuat data:', e)
  }
})

const getPercentage = () => {
  if (total.value === 0) return 0
  return ((lebihDari2.value / total.value) * 100).toFixed(1)
}
</script>

<template>
  <div class="mt-6 bg-red-700 p-6 rounded-3xl shadow w-full">
    <h2 class="text-lg font-bold mb-4 text-white">
      Jumlah Ibu yang Memiliki Anak Lebih dari 2
    </h2>

    <div class="text-sm mb-2 text-white">
      {{ lebihDari2 }} dari {{ total }} ibu memiliki lebih dari 2 anak.
    </div>

    <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
      <div
        class="bg-yellow-400 h-6 rounded-full text-black text-sm flex items-center justify-center"
        :style="{ width: getPercentage() + '%' }"
      >
        {{ getPercentage() }}%
      </div>
    </div>
  </div>
</template>