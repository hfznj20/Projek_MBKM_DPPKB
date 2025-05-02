<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head, Link, usePage } from '@inertiajs/vue3';

interface Penduduk {
  id: number
  nik: string
  nama: string
  kecamatan: string
  kelurahan: string
  kategori: string
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  {
    title: 'Data Penduduk',
    href: '/penduduk',
  },
];

const { props } = usePage();
const penduduks = ref<Penduduk[]>(props.penduduks as Penduduk[]);

const router = useRouter();
const successMessage = ref('');

const deletePenduduk = async (nik: number) => {
  if (!confirm('Yakin mau hapus?')) return;
  try {
    successMessage.value = 'Data berhasil dihapus';
    // fetchPenduduks() jika ingin di-refresh otomatis
  } catch (error) {
    console.error('Gagal menghapus data:', error);
  }
};

const editPenduduk = (id: number) => {
  router.push({ name: 'penduduk-edit', params: { id } });
};

</script>

<template>
  <Head title="Baduta TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Data Penduduk</h2>

      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

      <Link
        href="/penduduk/create"
        class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
      >
        Tambah Data
      </Link>

      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kelurahan</th>
            <th>Kategori</th>
            <th>Aksi</th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="(penduduk, index) in penduduks" :key="penduduk.id">
            <td>{{ index + 1 }}</td>
            <td>{{ penduduk.nik }}</td>
            <td>{{ penduduk.nama }}</td>
            <td>{{ penduduk.kecamatan }}</td>
            <td>{{ penduduk.kelurahan }}</td>
            <td>{{ penduduk.kategori }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="editPenduduk(penduduk.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deletePenduduk(penduduk.id)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
