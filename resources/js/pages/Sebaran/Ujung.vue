<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue'
import axios from 'axios'
import { BreadcrumbItem } from '@/types'
import { ref, onMounted } from 'vue'
import UmurChart from '@/components/UmurChart.vue'
import StuntingTable from '@/components/StuntingTable.vue'
import TTDProgress from '@/components/TTDProgress.vue'
import IbuAnakLebih2Progress from '@/components/IbuAnakLebih2Progress.vue'
import AksesAirLayakProgress from '@/components/AksesAirLayakProgress.vue'

const balitaLaki = ref(0)
const balitaPerempuan = ref(0)

const jumlahBaduta = ref<number | null>(null)
const jumlahCatin = ref<number | null>(null)
const jumlahBumil = ref<number | null>(null)
const jumlahPascaPersalinan = ref<number | null>(null)

onMounted(async () => {
  try {
    const response = await axios.get('/api/sebaran/ujung')
    const data = response.data
    balitaLaki.value = data.baduta_laki
    balitaPerempuan.value = data.baduta_perempuan
    jumlahBaduta.value = data.baduta
    jumlahCatin.value = data.catin
    jumlahBumil.value = data.bumil
    jumlahPascaPersalinan.value = data.pasca_persalinan
  } catch (error) {
    console.error('Gagal mengambil data:', error)
  }
})

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Baduta', href: '/Ujung' },
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-5 bg-white-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-6 text-black-700">DASHBOARD KECAMATAN UJUNG</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-w-screen-lg mx-auto">
        <!-- Total Baduta -->
        <div class="bg-red-700 text-white p-6 rounded-3xl shadow w-full">
          <h2 class="text-lg font-bold mb-2">Total Baduta Tercatat</h2>
          <div class="text-5xl font-bold flex items-center gap-4">
            👶 {{ jumlahBaduta }}
          </div>
          <!-- Jenis kelamin -->
          <div class="mt-4 border-b border-red-400 pt-4 bg-yellow-500 rounded-xl px-4 py-2 text-sm">
            <div class="flex justify-between text-center text-white">
              <span class="flex-1">👦 (Laki - Laki) : {{ balitaLaki }}</span>
              <span class="flex-1">|</span>
              <span class="flex-1">👧 (Perempuan) : {{ balitaPerempuan }}</span>
            </div>
          </div>
        </div>

        <!-- UmurChart -->
        <div class="bg-red-700 p-6 rounded-3xl shadow w-full">
          <UmurChart /> <!-- Panggil komponen UmurChart -->
        </div>

        <!-- Total Posyandu -->
        <div class="bg-red-700 text-white p-6 rounded-3xl shadow w-full md:col-span-2">
          <h2 class="text-lg font-bold mb-2">Total Posyandu</h2>
          <div class="text-5xl font-bold flex items-center gap-4">
            🏥 27
          </div>
        </div>

        <!-- Data Stunting per Kelurahan -->
        <div class="bg-red-700 text-white p-6 rounded-3xl shadow w-full md:col-span-2">
          <h2 class="text-lg font-bold mb-2">Data Stunting per Kelurahan</h2>
          <StuntingTable />
        </div>

        <div class="bg-red-700 text-white p-6 rounded-3xl shadow w-full md:col-span-1">
          <TTDProgress />
          <IbuAnakLebih2Progress />
          <AksesAirLayakProgress />
        </div>
      </div>
    </div>
  </AppLayout>
</template>