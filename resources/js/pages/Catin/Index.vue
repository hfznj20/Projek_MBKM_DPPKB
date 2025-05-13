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
  { title: 'Calon Penagantin', href: '/calon-pengantin' },
];

interface Catin {
  id: number;
  nik_catin1: string;
  nama_catin1: string;
  nik_catin2: string;
  nama_catin2: string;
  tanggal_rencana_pernikahan: string;
  niktpk: string;
}

const { props } = usePage<{
  auth: { user: { role: string } };
  catins: Catin[];
}>();

const user = props.auth.user;
const catins = ref<Catin[]>(props.catins);
const search = ref('');
const itemsPerPage = ref(5);
const currentPage = ref(1);
const searchCategory = ref('nama_catin1');

const filteredCatin = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;

  return catins.value.filter((data) => {
    const value = data[category as keyof Catin];
    return String(value).toLowerCase().includes(keyword);
  });
});

const paginatedCatin = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredCatin.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(filteredCatin.value.length / itemsPerPage.value));

const changePage = (page: number) => {
  currentPage.value = page;
};

const viewData = (nik: string) => {
  Inertia.visit(`/catin/${nik}`);
};
</script>

<template>
  <Head title="Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
        <div class="flex items-center gap-2">
          <label for="itemsPerPage" class="text-sm text-gray-600">Tampilkan:</label>
          <select v-model="itemsPerPage" id="itemsPerPage" class="border border-orange-500 rounded-lg px-3 py-1 text-sm text-orange-500">
            <option :value="5">5</option>
            <option :value="10">10</option>
            <option :value="20">20</option>
            <option :value="50">50</option>
            <option :value="100">100</option>
            <option :value="1000">1000</option>
          </select>
        </div>

        <div class="relative w-full md:w-1/3">
          <div class="flex items-center border border-orange-500 rounded-lg px-2 py-1 bg-white">
            <MagnifyingGlassIcon class="w-5 h-5 text-neutral-400" />
            <input
              v-model="search"
              type="text"
              placeholder="Cari..."
              class="w-full border-none outline-none text-sm text-neutral-700 bg-transparent"
            />
          </div>
        </div>
      </div>

      <div class="overflow-x-auto border border-orange-500 rounded-lg shadow">
        <table class="min-w-full">
          <thead class="bg-orange-500 text-white">
            <tr>
              <th class="px-4 py-2 text-left text-sm">No</th>
              <th class="px-4 py-2 text-left text-sm">NIK Calon Wanita</th>
              <th class="px-4 py-2 text-left text-sm">Nama Calon Wanita</th>
              <th class="px-4 py-2 text-left text-sm">NIK Calon Pria</th>
              <th class="px-4 py-2 text-left text-sm">Nama Calon Pria</th>
              <th class="px-4 py-2 text-left text-sm">Tanggal Rencana Pernikahan</th>
              <th v-if="user.role !== 'TPK'" class="px-4 py-2 text-left text-sm">TPK</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedCatin.length === 0" class="text-center text-gray-500">
              <td colspan="8" class="px-4 py-4">Tidak ada data catin.</td>
            </tr>
            <tr v-for="(data, index) in paginatedCatin" :key="data.id" class="hover:bg-orange-50 border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nik_catin1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nama_catin1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nik_catin2 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nama_catin2 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.tanggal_rencana_pernikahan }}</td>
              <td v-if="user.role !== 'TPK'" class="px-4 py-2 text-sm">{{ data.niktpk }}</td>
              <td class="px-4 py-2">
                <button @click="viewData(data.nik_catin1)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                  <EyeIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex justify-end items-center gap-1 p-2">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="px-2 py-1 text-xs bg-gray-800 text-white rounded-md disabled:opacity-50">&laquo;</button>
        <button v-if="currentPage > 1" @click="changePage(currentPage - 1)" class="px-2 py-1 text-xs bg-gray-700 text-white rounded-md">{{ currentPage - 1 }}</button>
        <span class="px-2 py-1 text-xs bg-orange-600 text-white rounded-md font-semibold">{{ currentPage }}</span>
        <button v-if="currentPage < totalPages" @click="changePage(currentPage + 1)" class="px-2 py-1 text-xs bg-gray-700 text-white rounded-md">{{ currentPage + 1 }}</button>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-2 py-1 text-xs bg-gray-800 text-white rounded-md disabled:opacity-50">&raquo;</button>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.hover\:bg-orange-50:hover {
  background-color: #fef2f2; /* Light orange */
}
</style>