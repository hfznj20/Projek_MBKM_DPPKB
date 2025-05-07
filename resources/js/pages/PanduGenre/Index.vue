<script setup lang="ts">
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { TrashIcon, EyeIcon } from '@heroicons/vue/24/outline';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/solid';
import Barchart3 from '@/components/ui/Barchart3.vue';
import { UserPlusIcon } from '@heroicons/vue/24/solid';

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Beranda', href: '/dashboard' },
    { title: 'Pandu Genre', href: '/pandu-genre' },
];

// State untuk pencarian
const search = ref('');

// Fungsi untuk melihat detail user
const viewDetails = (nik: string) => {
    alert(`Melihat detail untuk NIK: ${nik}`);
};

// Fungsi untuk menghapus data user
const deleteData = (nik: string) => {
    const confirmDelete = confirm(`Apakah Anda yakin ingin menghapus data dengan NIK: ${nik}?`);
    if (confirmDelete) {
        tableData.value = tableData.value.filter((data) => data.nik !== nik);
    }
};

// Fungsi untuk menambah user
const addUser = () => {
  router.push({ name: 'AddUserForm' }); // Arahkan ke form tambah user
};
</script>

<template>
    <Head title="Pandu Genre" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <!-- Input Pencarian dan Tombol Tambah -->
            <div class="flex flex-col md:flex-row justify-end items-center mb-4 mt-4 space-y-4 md:space-y-0 md:space-x-4">
                <!-- Input Pencarian -->
                <div class="relative w-full md:w-72">
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

               <!-- Tombol Tambah User -->
        <div class="w-full md:w-auto">
          <button
            class="flex items-center justify-center gap-2 bg-[#071556] hover:bg-[#0b1c70] text-white text-sm px-4 py-2 rounded-lg w-full md:w-auto"
            @click="addUser"
          >
            <UserPlusIcon class="w-5 h-5" />
            Tambah Data
          </button>
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
                        <tr v-if="filteredTableData.length === 0" class="text-center text-gray-500">
                            <td colspan="6" class="px-4 py-4">Tidak ada data.</td>
                        </tr>
                        <tr
                            v-for="(data, index) in filteredTableData"
                            :key="data.nik"
                            class="border-t hover:bg-gray-50"
                        >
                            <td class="px-4 py-2">{{ index + 1 }}</td>
                            <td class="px-4 py-2">{{ data.nik }}</td>
                            <td class="px-4 py-2">{{ data.nama }}</td>
                            <td class="px-4 py-2">{{ data.kecamatan }}</td>
                            <td class="px-4 py-2">{{ data.kelurahan }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <button
                                    @click="viewDetails(data.nik)"
                                    class="text-blue-600 hover:text-blue-800"
                                    title="Melihat Detail"
                                >
                                    <EyeIcon class="w-5 h-5" />
                                </button>
                                <button
                                    @click="deleteData(data.nik)"
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

<style scoped>
/* Tambahkan styling tambahan jika diperlukan */
</style>
