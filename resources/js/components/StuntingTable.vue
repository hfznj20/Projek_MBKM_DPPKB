<template>
  <div class="mt-6 bg-white p-6 rounded-3xl shadow w-full">
    <h2 class="text-lg font-bold mb-4 text-black">Tabel Stunting per Kelurahan</h2>
    <table class="min-w-full text-sm text-left text-gray-700 border">
      <thead class="bg-red-700 text-white">
        <tr>
          <th class="px-4 py-2 border">Nama Kelurahan</th>
          <th class="px-4 py-2 border">Jumlah Bayi Stunting</th>
          <th class="px-4 py-2 border">Proporsi Stunting</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in stuntingData" :key="index" class="hover:bg-gray-100">
          <td class="px-4 py-2 border">{{ item.kelurahan }}</td>
          <td class="px-4 py-2 border">{{ item.jumlah_stunting }}</td>
          <td class="px-4 py-2 border">{{ item.proporsi }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stuntingData = ref<any[]>([])

onMounted(async () => {
  try {
    const res = await axios.get('/api/stunting-per-kelurahan')
    stuntingData.value = res.data
  } catch (e) {
    console.error('Gagal mengambil data stunting per kelurahan:', e)
  }
})
</script>