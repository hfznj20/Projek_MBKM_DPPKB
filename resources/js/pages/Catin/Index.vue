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
  niktpk: string;
}

const { props } = usePage<{
  auth: { user: { role: string } };
  catins: Catin[];
}>();

const user = props.auth.user;
const catins = ref<Catin[]>(props.catins);
const search = ref('');
const filteredCatin = computed(() => {
  const keyword = search.value.toLowerCase();

  return catins.value.filter((data) => {
    return Object.values(data).some((value) =>
      String(value).toLowerCase().includes(keyword)
    );
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
        Data Catin
      </h1>

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
              <th class="px-4 py-2 text-left">No</th>
              <th class="px-4 py-2 text-left">NIK Calon Wanita</th>
              <th class="px-4 py-2 text-left">Nama Calon Wanita</th>
              <th class="px-4 py-2 text-left">NIK Calon Pria</th>
              <th class="px-4 py-2 text-left">Nama Calon Pria</th>
              <th class="px-4 py-2 text-left">Tanggal Rencana Pernikahan</th>
              <th v-if="user.role !== 'TPK'" class="px-4 py-2 text-left">TPK</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="filteredCatin.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4 text-sm">Tidak ada data catin.</td>
            </tr>
            <tr v-for="(data, index) in filteredCatin" :key="data.id" class="border-t hover:bg-gray-50">
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ data.nik_catin1 }}</td>
              <td class="px-4 py-2">{{ data.nama_catin1 }}</td>
              <td class="px-4 py-2">{{ data.nik_catin2 }}</td>
              <td class="px-4 py-2">{{ data.nama_catin2 }}</td>
              <td class="px-4 py-2">{{ data.tanggal_rencana_pernikahan }}</td>
              <td v-if="user.role !== 'TPK'" class="px-4 py-2">{{ data.niktpk }}</td>
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

<style scoped>
table td, table th {
  white-space: nowrap;
}
</style>
