<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head, Link, usePage } from '@inertiajs/vue3';

interface baduta {
  id: number
  nik: string
  nama: string
  kecamatan: string
  kelurahan: string
  stunting: string
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Beranda', href: '/dashboard' },
  {
    title: 'Baduta',
    href: '/baduta',
  },
];

const { props } = usePage();
const badutas = ref<baduta[]>(props.badutas as baduta[]);

const router = useRouter();
const successMessage = ref('');

const deletebaduta = async (id: number) => {
  if (!confirm('Yakin mau hapus?')) return;
  try {
    successMessage.value = 'Data berhasil dihapus';
    // fetchPenduduks() jika ingin di-refresh otomatis
  } catch (error) {
    console.error('Gagal menghapus data:', error);
  }
};

const editbaduta = (id: number) => {
  router.push({ name: 'penduduk-edit', params: { id } });
};

</script>

<template>
  <Head title="Baduta TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Data Baduta</h2>

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
          <tr v-for="(baduta, index) in badutas" :key="baduta.id">
            <td>{{ index + 1 }}</td>
            <td>{{ baduta.nik }}</td>
            <td>{{ baduta.nama }}</td>
            <td>{{ baduta.kecamatan }}</td>
            <td>{{ baduta.kelurahan }}</td>
            <td>{{ baduta.stunting }}</td>
            <td>
              <button class="btn btn-primary btn-sm" @click="editbaduta(baduta.id)">Edit</button>
              <button class="btn btn-danger btn-sm" @click="deletebaduta(baduta.id)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout> 
</template>
