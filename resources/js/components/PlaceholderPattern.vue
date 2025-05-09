<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const patternId = `pattern-${Math.random().toString(36).substring(2, 9)}`
const stuntingPercent = ref(0)

// Ambil data dari backend
onMounted(async () => {
  try {
    const response = await axios.get('/api/baduta/stunting/persentase')
    stuntingPercent.value = response.data.persentase
  } catch (error) {
    console.error('Gagal ambil data stunting:', error)
  }
})

// Warna berdasarkan kategori WHO
const stuntingColorClass = computed(() => {
  const percent = stuntingPercent.value
  if (percent < 20) return 'text-green-500'
  if (percent < 30) return 'text-yellow-400'
  if (percent < 40) return 'text-blue-500'
  return 'text-red-600'
})
</script>

<template>
  <div class="relative w-full h-screen bg-whi-900">
    <!-- SVG pattern background -->
    <svg class="absolute inset-0 w-full h-full stroke-white/10" fill="none">
      <defs>
        <pattern :id="patternId" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse">
          <path d="M-1 5L5 -1M3 9L8.5 3.5" stroke-width="0.5" />
        </pattern>
      </defs>
      <rect stroke="none" :fill="`url(#${patternId})`" width="100%" height="100%" />
    </svg>

    <!-- Angka Persentase -->
<div
  class="text-[7vw] max-w-[50%] break-words font-extrabold text-center leading-none"
  :class="stuntingColorClass"
>
  {{ stuntingPercent }}%
</div>
  </div>
</template>