<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

// Definisikan tipe data untuk 1 item Bdtpk
interface Bdtpk {
  id: number;
  nik: string;
  nama: string;
}

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Baduta TPK',
    href: '/bdtpk',
  },
];

// Props
const props = defineProps<{
  bdtpks: Bdtpk[];
  search: string | null;
}>();

// Input search
const searchInput = ref(props.search || '');

const form = useForm({
  nik: "",
  nama: ""
});

function deleteItem(id: number): void {
  if (confirm('Yakin dek??')) {
    form.delete(route('bdtpk.destroy', id), {
      preserveScroll: true,
    });
  }
}


// Fungsi untuk kirim search ke server
function searchData(): void {
  router.get(route('bdtpk.index'), { search: searchInput.value }, {
    preserveState: true,
    replace: true,
  });
}
</script>

<template>
  <Head title="Baduta TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">

      <!-- Search Bar -->
      <div class="flex justify-between mb-4">
        <div class="flex gap-2">
          <input
            v-model="searchInput"
            @keyup.enter="searchData"
            type="text"
            placeholder="Cari NIK atau Nama..."
            class="px-4 py-2 border rounded-lg w-64"
          />
          <button @click="searchData" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Cari
          </button>
        </div>
        <Link
          href="/bdtpk/create"
          class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
        >
          Tambah Data
        </Link>
      </div>

      <!-- Table -->
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead>
          <tr class="text-left bg-gray-100">
            <th class="px-4 py-2 text-sm font-medium text-gray-600">ID</th>
            <th class="px-4 py-2 text-sm font-medium text-gray-600">NIK</th>
            <th class="px-4 py-2 text-sm font-medium text-gray-600">Nama</th>
            <th class="px-4 py-2 text-sm font-medium text-gray-600">Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Loop Data -->
          <tr v-for="bdtpk in bdtpks" :key="bdtpk.id" class="border-t border-gray-200">
            <td class="px-4 py-2 text-sm text-gray-700">{{ bdtpk.id }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ bdtpk.nik }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ bdtpk.nama }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">
              <div class="flex gap-2">
                <Link
                  :href="`/bdtpk/${bdtpk.id}/edit`"
                  class="px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600"
                >
                  Edit
                </Link>
                <button
                  @click="deleteItem(bdtpk.id)"
                  class="px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600"
                >
                  Delete
                </button>
              </div>
            </td>
          </tr>
          <!-- Kalau tidak ada data -->
          <tr v-if="bdtpks.length === 0">
            <td colspan="4" class="text-center py-4 text-gray-500">
              Tidak ada data ditemukan.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
