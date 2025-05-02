<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head, Link, usePage } from '@inertiajs/vue3';

interface Bumil {
  id: number;
  nik: string;
  nama: string;
  kecamatan: string;
  kelurahan: string;
  stunting: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  {
    title: 'Bumil',
    href: '/bumil',
  },
];

const { props } = usePage();
const bumils = ref<Bumil[]>(props.bumils as Bumil[]); // Menampilkan data yang sudah di-join

const router = useRouter();
const successMessage = ref('');

// Menghapus data bumil
const deletebumil = async (id: number) => {
  if (!confirm('Yakin mau hapus?')) return;

  try {
    successMessage.value = 'Data berhasil dihapus';
    // Segarkan data setelah penghapusan (misalnya reload atau fetch ulang)
  } catch (error) {
    console.error('Gagal menghapus data:', error);
  }
};

// Mengedit data bumil
const editbumil = (id: number) => {
  router.push({ name: 'bumil-edit', params: { id } });
};
</script>

<template>
  <Head title="Bumil TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Data Bumil</h2>

      <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kecamatan</th>
            <th>Kelurahan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(bumil, index) in bumils" :key="bumil.id">
            <td>{{ index + 1 }}</td>
            <td>{{ bumil.nik }}</td>
            <td>{{ bumil.nama }}</td>
            <td>{{ bumil.kecamatan }}</td>
            <td>{{ bumil.kelurahan }}</td>
            <td>{{ bumil.stunting }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="editbumil(bumil.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deletebumil(bumil.id)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
