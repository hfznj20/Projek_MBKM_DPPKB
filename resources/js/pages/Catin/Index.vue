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
const filteredCatin = computed(() => {
  const keyword = search.value.toLowerCase();
  return catinData.value.filter((data) =>
    Object.values(data).some(value =>
      String(value).toLowerCase().includes(keyword)
    )
  );
});

const viewData = (nik: string) => {
  Inertia.visit(`/catin/${nik}`);
};
</script>

<template>
  <Head title="Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <!-- Button Section -->
      <div class="flex gap-2 mb-4">
        <!-- Add buttons here if needed -->
      </div>

      <!-- Search -->
      <div class="flex flex-col lg:flex-row flex-wrap gap-4 justify-between items-start mb-4">
        <div class="flex items-center border border-[#F9690C] rounded-lg px-1 py-1 w-full lg:w-[273px]">
          <MagnifyingGlassIcon class="w-5 h-5 text-neutral-400 mr-2" />
          <input
            v-model="search"
            type="text"
            placeholder="Cari data catin..."
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
              <th class="px-4 py-2 text-left text-sm">NIK Calon Wanita</th>
              <th class="px-4 py-2 text-left text-sm">Nama Calon Wanita</th>
              <th class="px-4 py-2 text-left text-sm">NIK Calon Pria</th>
              <th class="px-4 py-2 text-left text-sm">Nama Calon Pria</th>
              <th class="px-4 py-2 text-left text-sm">Tanggal Rencana Pernikahan</th>
              <th class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredCatin.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4 text-sm">Tidak ada data catin.</td>
            </tr>
            <tr v-for="(data, index) in filteredCatin" :key="data.id" class="border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nik_catin1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nama_catin1 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nik_catin2 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.nama_catin2 }}</td>
              <td class="px-4 py-2 text-sm">{{ data.tanggal_rencana_pernikahan }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
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

<style scoped>
table td, table th {
  white-space: nowrap;
}
</style>