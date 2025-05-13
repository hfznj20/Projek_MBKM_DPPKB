<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { EyeIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { Inertia } from '@inertiajs/inertia';
import { type BreadcrumbItem } from '@/types';

// Props from server (Laravel Controller)
const props = defineProps<{ stuntingData: any[] }>();

// Breadcrumb data
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Stunting', href: '/stunting' },
];

// Local ref for stunting data
const stuntingData = ref([...props.stuntingData]);

// Search feature
const search = ref('');
const itemsPerPage = ref(5);
const currentPage = ref(1);

// Filter data based on search keywords
const filteredStunting = computed(() => {
  const keyword = search.value.toLowerCase();
  return stuntingData.value.filter((data) => {
    return (
      String(data.nik).toLowerCase().includes(keyword) ||
      data.nama.toLowerCase().includes(keyword) ||
      data.kecamatan?.toLowerCase().includes(keyword) ||
      data.kelurahan?.toLowerCase().includes(keyword)
    );
  });
});

// Paginate filtered data
const paginatedStunting = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredStunting.value.slice(start, start + itemsPerPage.value);
});

// Total pages calculation
const totalPages = computed(() => Math.ceil(filteredStunting.value.length / itemsPerPage.value));

// Change page function
const changePage = (page: number) => {
  currentPage.value = page;
};

// View data function
const viewData = (data: any) => {
  const kategori = data.statusStunting?.toLowerCase().trim();
  if (kategori === 'baduta') {
    Inertia.visit(`/baduta/${data.nik}`);
  } else if (kategori === 'bumil') {
    Inertia.visit(`/bumil/${data.nik}`);
  } else {
    alert('Kategori tidak dikenali: ' + data.statusStunting);
  }
};
</script>

<template>
  <Head title="Data Stunting TPK" />
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
              <th class="px-4 py-2 text-left text-sm">Kecamatan</th>
              <th class="px-4 py-2 text-left text-sm">Kelurahan</th>
              <th class="px-4 py-2 text-left text-sm">Kategori</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedStunting.length === 0">
              <td colspan="7" class="text-center py-4 text-gray-500 text-sm">Tidak ada data stunting.</td>
            </tr>
            <tr
              v-for="(data, index) in paginatedStunting"
              :key="data.id"
              class="hover:bg-orange-50 border-t border-orange-500"
            >
              <td class="px-4 py-2 text-sm">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ data.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ data.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ data.statusStunting }}</td>
              <td class="px-4 py-2 text-sm flex items-center">
                <button @click="viewData(data)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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