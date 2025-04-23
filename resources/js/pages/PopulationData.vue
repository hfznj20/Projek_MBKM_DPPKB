<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Penduduk', href: '/population_data' }
]

// Contoh data statis
// const population = [
//   { id: 1, nama: 'Ahmad Subari', usia: 34, alamat: 'Jl. Andi Mappatola' },
//   { id: 2, nama: 'Rina Aulia', usia: 28, alamat: 'Jl. Bau Massepe' },
//   { id: 3, nama: 'Siti Nurbaya', usia: 42, alamat: 'Jl. H.A. Djunaid' }
// ]
</script>

<template>
  <Head title="Data Penduduk" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4 text-gray-800">Data Penduduk</h1>

      <!-- <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300 rounded-lg">
          <thead class="bg-[#E7942A]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">#</th>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Usia</th>
              <th class="px-4 py-2 text-left">Alamat</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(warga, index) in population"
              :key="warga.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ warga.nama }}</td>
              <td class="px-4 py-2">{{ warga.usia }} tahun</td>
              <td class="px-4 py-2">{{ warga.alamat }}</td>
            </tr>
          </tbody>
        </table>
      </div> -->
    </div>
  </AppLayout>
</template>
