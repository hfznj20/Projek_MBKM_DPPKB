<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

// Ambil props dari Inertia (nik dari URL path)
const props = defineProps<{
  nik: string;
}>();

const form = useForm({
  nik: props.nik, // gunakan nik dari props
  tanggal_kunjungan: '',
  berat_badan: '',
  tinggi_badan: '',
  terapi_gizi: '',
  terapi_psikososial: '',
  kunjungan_rumah: '',
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Kunjungan', href: '/kunjungan/create' }
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.post('/pandu-genre/kunjungan', {
    onSuccess: () => {
        window.location.href = `/pandu-genre/${form.nik}`;  // Sesuaikan dengan kebutuhan
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>

<template>
  <Head title="Tambah Kunjungan" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Kunjungan</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.nik" />

        <div class="mb-3">
          <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
          <input v-model="form.tanggal_kunjungan" type="date" class="form-control" id="tanggal_kunjungan" required />
        </div>

        <div class="mb-3">
          <label for="berat_badan" class="form-label">Berat Badan</label>
          <input v-model="form.berat_badan" type="text" class="form-control" id="berat_badan" required />
        </div>

        <div class="mb-3">
          <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
          <input v-model="form.tinggi_badan" type="text" class="form-control" id="tinggi_badan" required />
        </div>

        <div class="mb-3">
          <label for="terapi_gizi" class="form-label">Terapi Gizi</label>
          <input v-model="form.terapi_gizi" type="text" class="form-control" id="terapi_gizi" />
        </div>

        <div class="mb-3">
          <label for="terapi_psikososial" class="form-label">Terapi Psikososial</label>
          <input v-model="form.terapi_psikososial" type="text" class="form-control" id="terapi_psikososial" />
        </div>

        <div class="mb-3">
          <label for="kunjungan_rumah" class="form-label">Kunjungan Rumah</label>
          <input v-model="form.kunjungan_rumah" type="text" class="form-control" id="kunjungan_rumah" />
        </div>

        <button type="submit" class="btn btn-success">Simpan Data</button>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan style jika diperlukan */
</style>
