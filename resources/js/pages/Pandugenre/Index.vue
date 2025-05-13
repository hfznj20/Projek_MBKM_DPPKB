<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { TrashIcon, EyeIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import type { BreadcrumbItem } from '@/types';
import Barchart3 from '@/components/ui/Barchart3.vue';

interface Pandugenre {
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Pandu Genre', href: '/pandu-genre' },
];

const { props } = usePage();
const pandugenres = ref<Pandugenre[]>(Array.isArray(props.pandugenres) ? props.pandugenres : []);

const search = ref('');

const filteredpandugenres = computed(() => {
  const keyword = search.value.toLowerCase();

  return pandugenres.value.filter((data) => {
    return (
      data.nik.toLowerCase().includes(keyword) ||
      data.nama.toLowerCase().includes(keyword) ||
      data.kecamatan.toLowerCase().includes(keyword) ||
      data.kelurahan.toLowerCase().includes(keyword)
    );
  });
});


const viewDetails = (nik: string) => {
  Inertia.visit(`/pandu-genre/${nik}`);
};

const deleteData = async (nik: string) => {
  if (!confirm('Yakin mau hapus?')) return;

  Inertia.delete(`/pandu-genre/${nik}`, {
    onSuccess: () => {
      alert('Data berhasil dihapus.');
    },
    onError: () => {
      alert('Terjadi kesalahan saat menghapus.');
    },
  });
};

</script>

<template>
  <Head title="Pandu Genre" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Pandu Genre
      </h1>

      <!-- Tombol Tambah -->
      <div class="flex justify-end my-4">
        <Link
          href="/pandu-genre/create"
          class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700"
        >
          Tambah Data
        </Link>
      </div>

      <!-- Pencarian -->
      <div class="flex flex-col md:flex-row justify-between mb-4 space-y-4 md:space-y-0 md:space-x-6">
        <div class="relative w-full md:w-1/3">
          <input
            v-model="search"
            type="text"
            placeholder="Cari..."
            class="w-full border border-[#F9690C] rounded-lg px-3 py-2 pr-10 text-sm focus:ring-2 focus:ring-[#F9690C] placeholder-[#F9690C]"
          />
          <MagnifyingGlassIcon class="w-5 h-5 text-[#F9690C] absolute right-3 top-1/2 transform -translate-y-1/2" />
        </div>
      </div>

      <!-- Tabel Data -->
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg">
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
            <tr v-if="filteredpandugenres.length === 0" class="text-center text-gray-500">
              <td colspan="7" class="px-4 py-4">Tidak ada data.</td>
            </tr>
            <tr
              v-for="(data, index) in filteredpandugenres"
              :key="data.nik"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ index + 1 }}</td>
              <td class="px-4 py-2">{{ data.nik }}</td>
              <td class="px-4 py-2">{{ data.nama }}</td>
              <td class="px-4 py-2">{{ data.kecamatan }}</td>
              <td class="px-4 py-2">{{ data.kelurahan }}</td>
              <td class="px-4 py-2 space-x-2 flex items-center">
                <button @click="viewDetails(data.nik)" class="text-blue-600 hover:text-blue-800" title="Detail">
                  <EyeIcon class="w-5 h-5" />
                </button>
                <button @click="deleteData(data.nik)" class="text-red-600 hover:text-red-800" title="Hapus">
                  <TrashIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Grafik -->
      <div class="mt-4">
        <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
          PERKEMBANGAN TUBUH BADUTA
        </div>
        <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
          <Barchart3 />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
