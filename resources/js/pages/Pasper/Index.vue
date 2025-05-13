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
  niktpk?: string; // Optional field
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Pasca Persalinan', href: '/pasca-persalinan' },
];

const { props } = usePage<{
  pasper: Pasper[];
  auth?: { user?: { role?: string } };
}>();

const paspers = ref<Pasper[]>(props.pasper ?? []);
const userRole = props.auth?.user?.role ?? '';

const search = ref('');
const itemsPerPage = ref(5);
const currentPage = ref(1);

const filteredpaspers = computed(() => {
  const keyword = search.value.toLowerCase();
  return paspers.value.filter((pasper) => {
    return pasper.nama.toLowerCase().includes(keyword) || pasper.nik.toLowerCase().includes(keyword);
  });
});

// Paginate filtered data
const paginatedPaspers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredpaspers.value.slice(start, start + itemsPerPage.value);
});

// Total pages calculation
const totalPages = computed(() => Math.ceil(filteredpaspers.value.length / itemsPerPage.value));

const changePage = (page: number) => {
  currentPage.value = page;
};

const viewData = (nik: string) => {
  Inertia.visit(`/pasper/${nik}`);
};
</script>

<template>
  <Head title="Pasca Persalinan" />
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

        <div class="flex items-center gap-2">
          <div class="flex items-center border border-orange-500 rounded-lg px-2 py-1 bg-white">
            <svg class="w-5 h-5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
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
              <th class="px-4 py-2 text-left text-sm">NIK</th>
              <th class="px-4 py-2 text-left text-sm">Nama</th>
              <th class="px-4 py-2 text-left text-sm">Kecamatan</th>
              <th class="px-4 py-2 text-left text-sm">Kelurahan</th>
              <th class="px-4 py-2 text-left text-sm">Tanggal Persalinan</th>
              <th v-if="userRole !== 'TPK'" class="px-4 py-2 text-left text-sm">TPK</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedPaspers.length === 0">
              <td colspan="8" class="text-center py-4 text-gray-500 text-sm">Tidak ada data Pasca Persalinan.</td>
            </tr>
            <tr
              v-for="(pasper, index) in paginatedPaspers"
              :key="pasper.nik"
              class="hover:bg-orange-50 border-t border-orange-500"
            >
              <td class="px-4 py-2 text-sm">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ pasper.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ pasper.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ pasper.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ pasper.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ pasper.tanggal_persalinan }}</td>
              <td v-if="userRole !== 'TPK'" class="px-4 py-2 text-sm">{{ pasper.niktpk }}</td>
              <td class="px-4 py-2 text-sm flex items-center">
                <button @click="viewData(pasper.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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