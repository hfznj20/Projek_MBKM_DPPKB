<template>
  <div class="mt-6 bg-red-700 p-6 rounded-3xl shadow w-full">
    <h2 class="text-lg font-bold mb-4 text-white">
      Calon Ibu Dan Ibu yang Menerima Tablet Tambah Darah (TTD)
    </h2>

    <div class="text-sm mb-2 text-white">
      {{ jumlahYa }} dari {{ totalBumil }} ibu telah menerima TTD
    </div>

    <div class="w-full bg-gray-200 rounded-full h-6">
      <div
        class="bg-green-500 h-6 rounded-full text-white text-sm flex items-center justify-center"
        :style="{ width: '${persentase}%' }"
      >
        {{ persentase }}%
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const jumlahYa = ref(0)
const totalBumil = ref(0)
const persentase = ref(0)

onMounted(async () => {
  try {
    const res = await axios.get('/api/bumil/ttd-ujung')
    jumlahYa.value = res.data.jumlah_ya
    totalBumil.value = res.data.total
    persentase.value = totalBumil.value > 0 ? Math.round((jumlahYa.value / totalBumil.value) * 100) : 0
  } catch (error) {
    console.error('Gagal mengambil data TTD:', error)
  }
})
</script>