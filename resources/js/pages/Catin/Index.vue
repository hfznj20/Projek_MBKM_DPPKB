<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { Inertia } from '@inertiajs/inertia';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Catin', href: '/calon-pengantin' },
];

interface Catin {
  id: number;
  nik_catin1: string;
  nama_catin1: string;
  nik_catin2: string;
  nama_catin2: string;
  tanggal_rencana_pernikahan: string;
}

const { props } = usePage();
const catinData = ref<Catin[]>(Array.isArray(props.catins) ? props.catins : []);

const search = ref('');
const searchCategory = ref('nama_catin1');

const filteredCatin = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;

  return catinData.value.filter((data) => {
    const value = data[category as keyof Catin];
    return String(value).toLowerCase().includes(keyword);
  });
});

const viewData = (nik: string) => {
  Inertia.visit(`/catin/${nik}`);
};
</script>

<template>
  <Head title="Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Catin TPK
      </h1>

      <!-- Search -->
      <div class="flex flex-col md:flex-row justify-between mb-4 mt-4 space-y-6 md:space-y-0 md:space-x-6">
        <div class="flex items-center w-full md:w-1/3 space-x-2">
          <label for="searchCategory" class="text-sm text-black whitespace-nowrap">Kategori</label>
          <select
            id="searchCategory"
            v-model="searchCategory"
            class="w-full ml-1 border border-[#F9690C] text-[#F9690C] rounded-lg px-3 py-2 text-sm"
          >
            <option value="nik_catin1">NIK Calon Wanita</option>
            <option value="nama_catin1">Nama Calon Wanita</option>
            <option value="nik_catin2">NIK Calon Pria</option>
            <option value="nama_catin2">Nama Calon Pria</option>
            <option value="tanggal_rencana_pernikahan">Tanggal Rencana Pernikahan</option>
          </select>
        </div>

        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon
            class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2"
          />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK Calon Wanita</th>
              <th class="px-4 py-2 text-left">Nama Calon Wanita</th>
              <th class="px-4 py-2 text-left">NIK Calon Pria</th>
              <th class="px-4 py-2 text-left">Nama Calon Pria</th>
              <th class="px-4 py-2 text-left">Tanggal Rencana Pernikahan</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredCatin.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4">Tidak ada data catin.</td>
            </tr>
            <tr v-for="(data, index) in filteredCatin" :key="data.id" class="border-t hover:bg-gray-50">
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ data.nik_catin1 }}</td>
              <td class="px-4 py-2">{{ data.nama_catin1 }}</td>
              <td class="px-4 py-2">{{ data.nik_catin2 }}</td>
              <td class="px-4 py-2">{{ data.nama_catin2 }}</td>
              <td class="px-4 py-2">{{ data.tanggal_rencana_pernikahan }}</td>
              <td class="px-4 py-2">
                <button @click="viewData(data.nik_catin1)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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