<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { EyeIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { Inertia } from '@inertiajs/inertia';

interface Bumil {
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
  stunting: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Bumil', href: '/bumil' },
];

const { props } = usePage();
const bumils = ref<Bumil[]>(props.bumils as Bumil[]);

const search = ref('');
const searchCategory = ref<'nik' | 'nama'>('nama');

const filteredBumils = computed(() => {
  const keyword = search.value.toLowerCase();
  const category = searchCategory.value;
  return bumils.value.filter((b) =>
    b[category].toLowerCase().includes(keyword)
  );
});

const viewData = (nik: string) => {
  Inertia.visit(`/bumil/${nik}`);
};

const deletebumil = async (nik: string) => {
  if (!confirm('Yakin mau hapus?')) return;
  Inertia.delete(`/bumil/${nik}`);
};


</script>

<template>
  <Head title="Bumil TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Bumil TPK
      </h1>

      <!-- Search -->
      <div class="flex flex-col md:flex-row justify-between mb-4 mt-4 space-y-6 md:space-y-0 md:space-x-6">
        <div class="flex items-center w-full md:w-1/3 space-x-2">
          <label class="text-sm text-black whitespace-nowrap">Kategori</label>
          <select
            v-model="searchCategory"
            class="w-full border border-[#F9690C] text-[#F9690C] rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#F9690C]"
          >
            <option value="nik">NIK</option>
            <option value="nama">Nama</option>
          </select>
        </div>

        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon
            class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none"
          />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK</th>
              <th class="px-4 py-2 text-left">Nama</th>
              <th class="px-4 py-2 text-left">Kecamatan</th>
              <th class="px-4 py-2 text-left">Kelurahan</th>
              <th class="px-4 py-2 text-left">Status Stunting</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredBumils.length === 0">
              <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada data bumil.</td>
            </tr>
            <tr
              v-for="(bumil, index) in filteredBumils"
              :key="bumil.nik"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ bumil.nik }}</td>
              <td class="px-4 py-2">{{ bumil.nama }}</td>
              <td class="px-4 py-2">{{ bumil.kecamatan }}</td>
              <td class="px-4 py-2">{{ bumil.kelurahan }}</td>
              <td class="px-4 py-2">{{ bumil.stunting }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
                <button @click="viewData(bumil.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                  <EyeIcon class="w-5 h-5" />
                </button>
                <button @click="deletebumil(bumil.nik)" class="text-red-600 hover:text-red-800">
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
