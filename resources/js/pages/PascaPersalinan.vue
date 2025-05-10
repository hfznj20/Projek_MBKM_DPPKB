<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';

interface Pasper {
  tanggal_persalinan: string;
  nik: string;
  kecamatan: string;
  kelurahan: string;
  nama: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Pasca Persalinan', href: '/pasca-persalinan' },
];

const { props } = usePage();
const paspers = ref<Pasper[]>(props.pasper as Pasper[]);

const search = ref('');
const searchCategory = ref('nama');

const filteredpaspers = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;
  
  return paspers.value.filter((pasper) => {
    return String(pasper[category as keyof Pasper]).toLowerCase().includes(keyword);
  });
});

const viewData = (nik: string) => {
  Inertia.visit(`/pasper/${nik}`);
};
</script>

<template>
  <Head title="Pasca Persalinan" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Pasca Persalinan
      </h1>

      <!-- Search -->
      <div class="flex flex-col md:flex-row justify-between mb-4 mt-4 space-y-6 md:space-y-0 md:space-x-6">
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
          </select>
        </div>

        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <svg class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>
      
      <!-- Table -->
      <div class="overflow-x-auto mt-4">
        <table class="min-w-full table-auto border border-gray-300 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK</th>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Kecamatan</th>
              <th class="px-4 py-2 text-left">Kelurahan</th>
              <th class="px-4 py-2 text-left">Tanggal Persalinan</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredpaspers.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4">Tidak ada data Pasca Persalinan.</td>
            </tr>
            <tr
              v-for="(pasper, index) in filteredpaspers"
              :key="pasper.nik"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ pasper.nik }}</td>
              <td class="px-4 py-2">{{ pasper.nama }}</td>
              <td class="px-4 py-2">{{ pasper.kecamatan }}</td>
              <td class="px-4 py-2">{{ pasper.kelurahan }}</td>
              <td class="px-4 py-2">{{ pasper.tanggal_persalinan }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
                <button @click="viewData(pasper.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                  <EyeIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
