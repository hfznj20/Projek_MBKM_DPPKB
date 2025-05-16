<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { PencilIcon, TrashIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { DocumentCheckIcon, UserPlusIcon } from '@heroicons/vue/24/solid';
import type { BreadcrumbItem } from '@/types';
// Gunakan ini untuk TypeScript
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';

interface Penduduk {
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
  kategori: string;
  niktpk: string;
}

const { props } = usePage<{ auth: { user: { role: string } }; penduduks: Penduduk[] }>();
const user = props.auth.user;
const penduduks = ref<Penduduk[]>(props.penduduks);
const search = ref('');
const searchCategory = ref('');
const showModal = ref(false);
const selectedId = ref<string | null>(null);
const showSuccess = ref(false);
const currentPage = ref(1);
const itemsPerPage = ref(5);

const filteredPenduduks = computed(() => {
  const keyword = search.value.toLowerCase();
  return penduduks.value.filter(p => {
    const allData = [p.nik, p.nama, p.kecamatan, p.kelurahan, p.kategori, p.niktpk].join(' ').toLowerCase();
    const matchSearch = allData.includes(keyword);
    const matchCategory = !searchCategory.value || p.kategori === searchCategory.value;
    return matchSearch && matchCategory;
  });
});

const paginatedPenduduks = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredPenduduks.value.slice(start, start + itemsPerPage.value);
});

const totalPages = computed(() => Math.ceil(filteredPenduduks.value.length / itemsPerPage.value));

const changePage = (page: number) => { currentPage.value = page; };

const exportToExcel = () => {
  const data = filteredPenduduks.value.map((p, i) => [i + 1, p.nik, p.nama, p.kecamatan, p.kelurahan, p.kategori, p.niktpk]);
  const header = ["No", "NIK", "Nama", "Kecamatan", "Kelurahan", "Kategori", "TPK"];
  const ws = XLSX.utils.aoa_to_sheet([header, ...data]);
  ws['!cols'] = [{ wch: 3 }, { wch: 20 }, { wch: 30 }, { wch: 20 }, { wch: 20 }, { wch: 20 }, { wch: 20 }];
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, 'Penduduk');
  const buffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
  saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'data_penduduk.xlsx');
};

const editPenduduk = (nik: string) => {
  Inertia.visit(`/penduduk/${nik}/edit`);
};

const deletePenduduk = (nik: string) => {
  selectedId.value = nik;
  showModal.value = true;
};

const deleteConfirmed = () => {
  if (selectedId.value) {
    Inertia.delete(`/penduduk/${selectedId.value}`, {
      onSuccess: () => {
        showSuccess.value = true;
        setTimeout(() => (showSuccess.value = false), 3000);
      }
    });
    selectedId.value = null;
  }
  showModal.value = false;
};

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Penduduk', href: '/penduduk' },
];
</script>

<template>
  <Head title="Data Penduduk" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <transition name="fade">
        <div v-if="showSuccess" class="fixed top-6 right-6 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50">
          Data berhasil dihapus!
        </div>
      </transition>

      <div class="flex gap-2 mb-4">
        <button @click="exportToExcel" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm px-4 py-1 rounded-lg shadow">
          <DocumentCheckIcon class="w-5 h-5" />
          Cetak Excel
        </button>
      </div>

      <div class="flex flex-wrap justify-between items-center mb-4 gap-2">
        <div class="flex items-center gap-2">
          <label for="itemsPerPage" class="text-sm text-gray-600">Tampilkan</label>
          <select v-model="itemsPerPage" id="itemsPerPage" class="border border-orange-500 rounded-lg px-3 py-1 text-sm text-orange-500">
            <option :value="5">5</option>
            <option :value="10">10</option>
            <option :value="20">20</option>
            <option :value="50">50</option>
          </select>
        </div>

        <div class="flex gap-2 flex-wrap items-center">
          <div class="flex items-center border border-orange-500 rounded-lg px-2 py-1 bg-white">
            <MagnifyingGlassIcon class="w-5 h-5 text-neutral-400" />
            <input v-model="search" placeholder="Cari..." class="w-full border-none outline-none text-sm text-neutral-700 bg-transparent" />
          </div>

          <select v-model="searchCategory" class="border border-orange-500 rounded-lg px-3 py-1 text-sm text-orange-500">
            <option value="">Semua Kategori</option>
            <option value="Penduduk">Penduduk</option>
            <option value="BADUTA">BADUTA</option>
            <option value="BUMIL">BUMIL</option>
            <option value="Pasca Persalinan">Pasca Persalinan</option>
            <option value="CATIN">CATIN</option>
          </select>

          <div v-if="user.role !== 'admin'">
            <Link href="/penduduk/create" class="flex items-center gap-1 bg-[#2F2E81] text-white text-sm px-3 py-1 rounded-md shadow hover:bg-[#1f1e5e]">
              <UserPlusIcon class="w-5 h-5" /> Tambah Data
            </Link>
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
              <th v-if="user.role !== 'TPK'" class="px-4 py-2 text-left text-sm">TPK</th>
              <th v-if="user.role !== 'admin'" class="px-4 py-2 text-left text-sm">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="paginatedPenduduks.length === 0">
              <td colspan="8" class="text-center py-4 text-gray-500 text-sm">Tidak ada data penduduk.</td>
            </tr>
            <tr v-for="(p, i) in paginatedPenduduks" :key="p.nik" class="hover:bg-orange-50 border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ (currentPage - 1) * itemsPerPage + i + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ p.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ p.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ p.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ p.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ p.kategori }}</td>
              <td v-if="user.role !== 'TPK'" class="px-4 py-2 text-sm">{{ p.niktpk }}</td>
              <td v-if="user.role !== 'admin'" class="px-4 py-2 text-sm">
                <button @click="editPenduduk(p.nik)" class="text-blue-600 hover:text-blue-800"><PencilIcon class="w-5 h-5" /></button>
                <button @click="deletePenduduk(p.nik)" class="text-red-600 hover:text-red-800 ml-2"><TrashIcon class="w-5 h-5" /></button>
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

  <transition name="fade">
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200/50 backdrop-blur-sm">
      <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
        <div class="flex justify-center mb-4">
          <div class="bg-white rounded-full p-4 border-4 border-orange-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" />
            </svg>
          </div>
        </div>
        <h2 class="text-2xl font-bold text-orange-600 mb-2">Konfirmasi Hapus</h2>
        <p class="text-black text-sm mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
        <div class="flex justify-center gap-4">
          <button @click="showModal = false" class="bg-gray-500 text-white px-6 py-2 rounded-xl hover:bg-gray-600">Batal</button>
          <button @click="deleteConfirmed" class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700">Hapus</button>
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
