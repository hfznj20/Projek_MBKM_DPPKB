<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { type BreadcrumbItem } from '@/types';
import { useRouter } from 'vue-router';

// Props dari server (Laravel Controller)
const props = defineProps<{ stuntingData: any[] }>();

// Data breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Stunting', href: '/stunting-tpk' },
];

// Salin props ke ref agar bisa dimodifikasi secara lokal
const stuntingData = ref([...props.stuntingData]);

// Pencarian
const search = ref('');
const searchCategory = ref('nama');

// Filter berdasarkan kategori pencarian
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


// Menambahkan fungsi untuk view data
const router = useRouter();

const viewData = (id: number) => {
  // Arahkan ke halaman detail dengan parameter id
  router.push({ name: 'baduta-detail', params: { id } });
};

</script>

<template>
  <Head title="Data Stunting TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-xl">
        Data Stunting
      </h1>

      <!-- Pencarian dan Dropdown -->
      <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
        <div class="w-full md:w-1/3">
          <label for="searchCategory" class="text-sm text-gray-700 block mb-1">Kategori Pencarian</label>
          <select
            id="searchCategory"
            v-model="searchCategory"
            class="w-full border border-[#F9690C] text-[#F9690C] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#F9690C]"
          >
            <option value="nik">NIK</option>
            <option value="nama">Nama</option>
            <option value="kecamatan">Kecamatan</option>
            <option value="kelurahan">Kelurahan</option>
          </select>
        </div>

        <div class="w-full md:w-1/3 relative">
          <label for="search" class="text-sm text-gray-700 block mb-1">Kata Kunci</label>
          <input
            id="search"
            v-model="search"
            type="text"
            placeholder="Cari data..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon class="w-5 h-5 text-[#F9690C] absolute right-3 top-10 transform -translate-y-1/2 pointer-events-none" />
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full table-auto">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-3 text-left">No</th>
              <th class="px-4 py-3 text-left">NIK</th>
              <th class="px-4 py-3 text-left">Nama</th>
              <th class="px-4 py-3 text-left">Kecamatan</th>
              <th class="px-4 py-3 text-left">Kelurahan</th>
              <th class="px-4 py-3 text-left">Kategori</th>
              <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredStunting.length === 0" class="text-center text-gray-500">
              <td colspan="5" class="px-4 py-6">Tidak ada data stunting.</td>
            </tr>
            <tr
              v-for="(data, index) in filteredStunting"
              :key="data.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-3">{{ index + 1 }}</td>
              <td class="px-4 py-3">{{ data.nik }}</td>
              <td class="px-4 py-3">{{ data.nama }}</td>
              <td class="px-4 py-3">{{ data.kecamatan }}</td>
              <td class="px-4 py-3">{{ data.kelurahan }}</td>
              <td class="px-4 py-3">{{ data.statusStunting }}</td>
              <td class="px-4 py-3 flex items-center space-x-2">
                <button @click="viewData(data.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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

<style scoped>
/* Styling tambahan jika perlu */
</style>
