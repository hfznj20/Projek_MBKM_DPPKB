<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { PencilIcon, TrashIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { DocumentCheckIcon, UserPlusIcon } from '@heroicons/vue/24/solid';
import type { BreadcrumbItem } from '@/types';
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

const exportToExcel = () => {
  const data = filteredPenduduks.value.map((penduduk, index) => ([
    index + 1,
    penduduk.nik,
    penduduk.nama,
    penduduk.kecamatan,
    penduduk.kelurahan,
    penduduk.kategori,
    penduduk.niktpk,
  ]));

  // Menambahkan header untuk tabel
  const header = [
    "No", "NIK", "Nama", "Kecamatan", "Kelurahan", "Kategori", "TPK"
  ];

  // Membuat worksheet
  const worksheet = XLSX.utils.aoa_to_sheet([header, ...data]);
  
  // Mengatur lebar kolom
  const columnWidths = [
    { wch: 3 },  // No
    { wch: 20 }, // NIK
    { wch: 30 }, // Nama
    { wch: 20 }, // Kecamatan
    { wch: 20 }, // Kelurahan
    { wch: 20 }, // Kategori
    { wch: 20 }, // TPK
  ];

  worksheet['!cols'] = columnWidths; // Mengatur lebar kolom di worksheet

  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, 'Penduduk');

  const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
  const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
  saveAs(blob, 'data_penduduk.xlsx');
};

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  { title: 'Data Penduduk', href: '/penduduk' },
];

const { props } = usePage<{
  auth: { user: { role: string } };
  penduduks: Penduduk[];
}>();

const user = props.auth.user;
const penduduks = ref<Penduduk[]>(props.penduduks);
const search = ref('');
const searchCategory = ref('');
const showModal = ref(false);
const selectedId = ref<string | null>(null);
const showSuccess = ref(false);

const filteredPenduduks = computed(() => {
  const keyword = search.value.toLowerCase();

  return penduduks.value.filter((penduduk) => {
    const allData = [
      penduduk.nik,
      penduduk.nama,
      penduduk.kecamatan,
      penduduk.kelurahan,
      penduduk.kategori,
      penduduk.niktpk
    ].join(' ').toLowerCase();

    const matchSearch = allData.includes(keyword);
    const matchCategory = searchCategory.value === '' || penduduk.kategori === searchCategory.value;

    return matchSearch && matchCategory;
  });
});

const editPenduduk = (nik: string) => {
  Inertia.visit(`/penduduk/${nik}/edit`);
};

const deletePenduduk = (nik: string) => {
  selectedId.value = nik;
  showModal.value = true;
};

const deleteConfirmed = () => {
  if (selectedId.value !== null) {
    Inertia.delete(`/penduduk/${selectedId.value}`, {
      onSuccess: () => {
        showSuccess.value = true;
        setTimeout(() => showSuccess.value = false, 3000);
      }
    });
    selectedId.value = null;
  }
  showModal.value = false;
};

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
        <button @click="exportToExcel" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white text-sm px-4 py-1 rounded-lg">
          <DocumentCheckIcon class="w-5 h-5" />
          Cetak Excel
        </button>
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Data Penduduk
      </h1>

      <!-- Tombol Tambah Data -->
      <div v-if="user.role !== 'admin'" class="flex justify-end my-4">
        <Link
          href="/penduduk/create"
          class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded hover:bg-green-700"
        >
          Tambah Data
        </Link>
      </div>

      <div class="flex flex-col lg:flex-row flex-wrap gap-4 justify-between items-start lg:items-center mb-4">
        <div class="flex items-center border border-[#F9690C] rounded-lg px-1 py-1 w-[273px]">
          <MagnifyingGlassIcon class="w-5 h-5 text-neutral-400 mr-2" />
          <input
            v-model="search"
            type="text"
            placeholder="Cari data penduduk..."
            class="w-full border-none focus:outline-none text-sm text-neutral-400 placeholder:text-neutral-400"
          />
        </div>

        <div class="flex items-center gap-4">
          <select
            v-model="searchCategory"
            class="border border-[#F9690C] rounded-lg px-3 py-1 text-sm text-[#F9690C] focus:ring-2 focus:ring-[#F9690C]"
          >
            <option value="">Semua Kategori</option>
            <option value="Penduduk">Penduduk</option>
            <option value="BADUTA">BADUTA</option>
            <option value="BUMIL">BUMIL</option>
            <option value="Pasca Persalinan">Pasca Persalinan</option>
            <option value="CATIN">CATIN</option>
          </select>

          <Link
            href="/penduduk/create"
            class="flex items-center gap-2 bg-[#2F2E81] text-white text-sm px-4 py-1 rounded-md hover:bg-[#1f1e5e]"
          >
            <UserPlusIcon class="w-5 h-5" />
            Tambah Data
          </Link>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full border border-orange-500 rounded-lg">
          <thead class="bg-[#F9690C]/90 text-white">
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
            <tr v-if="filteredPenduduks.length === 0" class="text-center text-gray-500">
              <td colspan="8" class="px-4 py-4 text-sm">Tidak ada data penduduk.</td>
            </tr>
            <tr v-for="(penduduk, index) in filteredPenduduks" :key="penduduk.nik" class="border-t border-orange-500">
              <td class="px-4 py-2 text-sm">{{ index + 1 }}</td>
              <td class="px-4 py-2 text-sm">{{ penduduk.nik }}</td>
              <td class="px-4 py-2 text-sm">{{ penduduk.nama }}</td>
              <td class="px-4 py-2 text-sm">{{ penduduk.kecamatan }}</td>
              <td class="px-4 py-2 text-sm">{{ penduduk.kelurahan }}</td>
              <td class="px-4 py-2 text-sm">{{ penduduk.kategori }}</td>
              <td v-if="user.role !== 'TPK'" class="px-4 py-2 text-sm">{{ penduduk.niktpk }}</td>
              <td v-if="user.role !== 'admin'" class="px-4 py-2 space-x-2 flex items-center">
                <button @click="editPenduduk(penduduk.nik)" class="text-blue-600 hover:text-blue-800" title="Edit">
                  <PencilIcon class="w-5 h-5" />
                </button>
                <button @click="deletePenduduk(penduduk.nik)" class="text-red-600 hover:text-red-800" title="Hapus">
                  <TrashIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>

  <transition name="fade">
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200/50 backdrop-blur-sm">
      <div class="bg-[#D9D9D9] rounded-xl shadow-lg p-6 w-full max-w-md text-center border-1 border-white">
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
          <button @click="showModal = false" class="bg-gray-500 text-white px-6 py-2 rounded-xl shadow-md hover:bg-gray-600">
            Batal
          </button>
          <button @click="deleteConfirmed" class="bg-red-600 text-white px-6 py-2 rounded-xl shadow-md hover:bg-red-700">
            Hapus
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>
