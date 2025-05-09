<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

interface Penduduk {
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
  kategori: string;
  niktpk: string;
}

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Penduduk', href: '/population_data' },
];

const { props } = usePage();
const penduduks = ref<Penduduk[]>(props.penduduks as Penduduk[]);

const search = ref('');
const searchCategory = ref('nama');

const filteredPenduduks = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;

  return penduduks.value.filter((penduduk) =>
    String(penduduk[category as keyof Penduduk] || '').toLowerCase().includes(keyword)
  );
});

</script>

<template>
  <Head title="Data Penduduk" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Penduduk
      </h1>

      <!-- Pencarian -->
      <div class="flex flex-col md:flex-row justify-between mb-4 space-y-4 md:space-y-0 md:space-x-6">
        <div class="flex items-center w-full md:w-1/3 space-x-2">
          <label for="searchCategory" class="text-sm text-black whitespace-nowrap">Kategori</label>
          <select
            id="searchCategory"
            v-model="searchCategory"
            class="w-full border border-[#F9690C] text-[#F9690C] rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#F9690C]"
          >
            <option value="nik">NIK</option>
            <option value="nama">Nama</option>
            <option value="kecamatan">Kecamatan</option>
            <option value="kelurahan">Kelurahan</option>
            <option value="kategori">Kategori</option>
            <option value="niktpk">TPK</option>

          </select>
        </div>

        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2" />
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK</th>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Kecamatan</th>
              <th class="px-4 py-2 text-left">Kelurahan</th>
              <th class="px-4 py-2 text-left">Kategori</th>
              <th class="px-4 py-2 text-left">TPK</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredPenduduks.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4">Tidak ada data penduduk.</td>
            </tr>
            <tr v-for="(penduduk, index) in filteredPenduduks" :key="penduduk.nik" class="border-t hover:bg-gray-50">
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ penduduk.nik }}</td>
              <td class="px-4 py-2">{{ penduduk.nama }}</td>
              <td class="px-4 py-2">{{ penduduk.kecamatan }}</td>
              <td class="px-4 py-2">{{ penduduk.kelurahan }}</td>
              <td class="px-4 py-2">{{ penduduk.kategori }}</td>
              <td class="px-4 py-2">{{ penduduk.niktpk }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
