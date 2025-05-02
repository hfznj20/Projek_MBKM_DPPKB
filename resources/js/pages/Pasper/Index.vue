<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head, Link, usePage } from '@inertiajs/vue3';

interface Pasper {
  id: number;
  tanggal_persalinan: string;
  nik: string;
  kecamatan: string;
  kelurahan: string;
  nama: string;
}

const breadcrumbs: BreadcrumbItem[] = [
{ title: 'Beranda', href: '/dashboard' },
  {
    title: 'Pasca Persalinan',
    href: '/pasper',
  },
];

const { props } = usePage();
const paspers = ref<Pasper[]>(props.pasper as Pasper[]); // Menampilkan data yang sudah di-join

const router = useRouter();
const successMessage = ref('');

// Menghapus data pasper
const deletePasper = async (id: number) => {
  if (!confirm('Yakin mau hapus?')) return;

  try {
    successMessage.value = 'Data berhasil dihapus';
    // Segarkan data setelah penghapusan (misalnya reload atau fetch ulang)
  } catch (error) {
    console.error('Gagal menghapus data:', error);
  }
};

// Mengedit data pasper
const editPasper = (id: number) => {
  router.push({ name: 'pasper-edit', params: { id } });
};
</script>

<template>
  <Head title="Pasper TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Data Pasca Persalinan</h2>

      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

      <!-- Tabel Data Pasper -->
      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kelurahan</th>
            <th>Tanggal Persalinan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(pasper, index) in paspers" :key="pasper.id">
            <td>{{ index + 1 }}</td>
            <td>{{ pasper.nik }}</td>
            <td>{{ pasper.nama }}</td>
            <td>{{ pasper.kecamatan }}</td>
            <td>{{ pasper.kelurahan }}</td>
            <td>{{ pasper.tanggal_persalinan }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="editPasper(pasper.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deletePasper(pasper.id)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
