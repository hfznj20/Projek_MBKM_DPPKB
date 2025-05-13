<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'; // Adjusted icon import
import { Inertia } from '@inertiajs/inertia';

interface Baduta {
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
  nama_ibu: string;
  stunting: string;
  niktpk: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Baduta', href: '/baduta' },
];

const { props } = usePage<{
  auth: { user: { role: string } };
  badutas: Baduta[];
}>();

const user = props.auth.user;
const badutas = ref<Baduta[]>(props.badutas);

const search = ref('');
const itemsPerPage = ref(5);
const currentPage = ref(1);

const filteredBaduta = computed(() => {
  const keyword = search.value.toLowerCase();
  return badutas.value.filter((baduta) => {
    return baduta.nama.toLowerCase().includes(keyword) || 
           baduta.nik.toLowerCase().includes(keyword);
  });
});

const paginatedBaduta = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredBaduta.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(filteredBaduta.value.length / itemsPerPage.value));

const changePage = (page: number) => {
  currentPage.value = page;
};

const viewData = (nik: string) => {
  Inertia.visit(`/baduta/${nik}`);
};
</script>

<template>
  <Head title="Data Baduta" />
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
              <th class="px-4 py-2 text-left text-sm">NIK</th>
              <th class="px-4 py-2 text-left text-sm">Nama</th>
              <th class="px-4 py-2 text-left text-sm">Nama Ibu</th>
              <th class="px-4 py-2 text-left text-sm">Kecamatan</th>
              <th class="px-4 py-2 text-left text-sm">Kelurahan</th>
              <th class="px-4 py-2 text-left text-sm">Stunting</th>
              <th v-if="user.role !== 'TPK'" class="px-4 py-2 text-left text-sm">TPK</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedBaduta.length === 0">
              <td colspan="8" class="text-center py-4 text-gray-500 text-sm">Tidak ada data baduta.</td>
            </tr>
            <tr v-for="(baduta, index) in paginatedBaduta" :key="baduta.nik" class="hover:bg-orange-50 border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nama_ibu }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.stunting }}</td>
              <td v-if="user.role !== 'TPK'" class="px-4 py-2 text-sm">{{ baduta.niktpk }}</td>
              <td class="px-4 py-2 text-sm flex items-center">
                <button @click="viewData(baduta.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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