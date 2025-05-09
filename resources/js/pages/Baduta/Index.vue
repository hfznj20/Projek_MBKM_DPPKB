<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
import { EyeIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import { DocumentArrowDownIcon, DocumentCheckIcon } from '@heroicons/vue/24/solid';
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

const badutas = ref<Baduta[]>(props.badutas);

const search = ref('');
const filteredBaduta = computed(() => {
  const keyword = search.value.toLowerCase().trim();
  if (!keyword) return badutas.value; // If no search keyword, return all data

  return badutas.value.filter((baduta) =>
    Object.values(baduta).some(value =>
      String(value).toLowerCase().includes(keyword)
    )
  );
});

const viewData = (nik: string) => {
  Inertia.visit(`/baduta/${nik}`);
};
</script>

<template>
  <Head title="Data Baduta" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <!-- Button Section -->
      <div class="flex gap-2 mb-4">
        <button class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-1 rounded-lg">
          <DocumentArrowDownIcon class="w-5 h-5" />
          Cetak PDF
        </button>

        <!-- Tombol Cetak Excel -->
        <button class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm px-4 py-1 rounded-lg">
          <DocumentCheckIcon class="w-5 h-5" />
          Cetak Excel
        </button>
      </div>

      <!-- Search -->
      <div class="flex flex-col lg:flex-row flex-wrap gap-4 justify-between items-start mb-4">
        <div class="flex items-center border border-[#F9690C] rounded-lg px-1 py-1 w-full lg:w-[273px]">
          <MagnifyingGlassIcon class="w-5 h-5 text-neutral-400 mr-2" />
          <input
            v-model="search"
            type="text"
            placeholder="Cari data baduta..."
            class="w-full border-none focus:outline-none text-sm text-neutral-400 placeholder:text-neutral-400"
          />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full border border-orange-500 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
            <tr>
              <th class="px-4 py-2 text-left text-sm">No</th>
              <th class="px-4 py-2 text-left text-sm">NIK</th>
              <th class="px-4 py-2 text-left text-sm">Nama</th>
              <th class="px-4 py-2 text-left text-sm">Nama Ibu</th>
              <th class="px-4 py-2 text-left text-sm">Kecamatan</th>
              <th class="px-4 py-2 text-left text-sm">Kelurahan</th>
              <th class="px-4 py-2 text-left text-sm">Status Stunting</th>
              <th class="px-4 py-2 text-left text-sm">TPK</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredBaduta.length === 0" class="text-center text-gray-500">
              <td colspan="9" class="px-4 py-4 text-sm">Tidak ada data baduta.</td>
            </tr>
            <tr v-for="(baduta, index) in filteredBaduta" :key="baduta.nik" class="border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.nama_ibu }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.stunting }}</td>
              <td class="px-4 py-2 text-sm">{{ baduta.niktpk }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
                <button @click="viewData(baduta.nik)" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
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
table td, table th {
  white-space: nowrap;
}
</style>
