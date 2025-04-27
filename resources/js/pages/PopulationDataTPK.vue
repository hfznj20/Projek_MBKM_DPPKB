<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'; 
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';

// Hapus deklarasi breadcrumbs di sini
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Penduduk tpk', href: '/population_data_tpk' },
];

const search = ref('');
const searchCategory = ref('nama'); // default pencarian

// Kosongkan data penduduk
const population = ref<any[]>([]);

const filteredPopulation = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;

  return population.value.filter((warga) => {
    if (category === 'nik') {
      return String(warga.nik).toLowerCase().includes(keyword);
    } else if (category === 'nama') {
      return warga.nama.toLowerCase().includes(keyword);
    } else if (category === 'kecamatan') {
      return warga.kecamatan.toLowerCase().includes(keyword);
    } else if (category === 'kelurahan') {
      return warga.kelurahan.toLowerCase().includes(keyword);
    }
    return false;
  });
});

// Fungsi untuk mengedit data penduduk
const editData = (id: number) => {
  alert(`Edit data penduduk dengan ID: ${id}`);
};

// Fungsi untuk menghapus data penduduk
const hapusData = (id: number) => {
  const confirmDelete = confirm(`Apakah Anda yakin ingin menghapus data dengan ID: ${id}?`);
  if (confirmDelete) {
    population.value = population.value.filter((warga) => warga.id !== id);
  }
};
</script>

<template>
  <Head title="Data Penduduk TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Penduduk TPK
      </h1>

      <!-- Pencarian dan Dropdown Kategori -->
      <div class="flex flex-col md:flex-row justify-between mb-4 mt-4 space-y-6 md:space-y-0 md:space-x-6">
        <div class="flex items-center w-full md:w-1/3 space-x-2">
          <label for="searchCategory" class="text-sm text-black whitespace-nowrap">Kategori</label>
          <div class="relative w-full">
            <select
              id="searchCategory"
              v-model="searchCategory"
              class="w-full ml-1 border border-[#F9690C] text-[#F9690C] rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#F9690C]"
            >
              <option value="nik">NIK</option>
              <option value="nama">Nama</option>
              <option value="kecamatan">Kecamatan</option>
              <option value="kelurahan">Kelurahan</option>
            </select>
          </div>
        </div>

        <!-- Input Pencarian -->
        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon
            class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"
          />
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK</th>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Kecamatan</th>
              <th class="px-4 py-2 text-left">Kelurahan</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredPopulation.length === 0" class="text-center text-gray-500">
              <td colspan="6" class="px-4 py-4">Tidak ada data penduduk.</td>
            </tr>
            <tr
              v-for="(warga, index) in filteredPopulation"
              :key="warga.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ warga.nik }}</td>
              <td class="px-4 py-2">{{ warga.nama }}</td>
              <td class="px-4 py-2">{{ warga.kecamatan }}</td>
              <td class="px-4 py-2">{{ warga.kelurahan }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
                <button
                  @click="editData(warga.id)"
                  class="text-blue-600 hover:text-blue-800"
                  title="Edit"
                >
                  <PencilIcon class="w-5 h-5" />
                </button>
                <button
                  @click="hapusData(warga.id)"
                  class="text-red-600 hover:text-red-800"
                  title="Hapus"
                >
                  <TrashIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
