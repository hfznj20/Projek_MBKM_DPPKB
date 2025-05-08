<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Pandu Genre', href: '/pandu-genre/create' },
];

const step = ref(1)
const showConfirmation = ref(false)
const badutaData = ref(null)

const searchNIK = ref('')
const error = ref('')
const allowContinue = ref(false)

const form = useForm({
  nik: '',
  terapi_gizi: '',
  terapi_psikososial: '',
  kunjungan_rumah: ''
})

const checkNIK = async () => {
  error.value = ''
  try {
    const response = await fetch(`/check-baduta/${searchNIK.value}`)

    if (!response.ok) {
      const data = await response.json()
      error.value = data.message || 'Terjadi kesalahan saat mencari NIK.'
      return
    }

    const data = await response.json()
    if (!data.exists) {
      error.value = 'NIK tidak ditemukan atau bukan kategori Baduta.'
      return
    }

    badutaData.value = data.baduta
    form.nik = data.baduta.nik

    if (!data.baduta.stunting) {
      showConfirmation.value = true
    } else {
      allowContinue.value = true
      step.value = 2
    }
  } catch (err) {
    error.value = 'Gagal terhubung ke server.'
  }
}


const confirmNonStunting = () => {
  showConfirmation.value = false
  allowContinue.value = true
  step.value = 2
}

const submit = () => {
  form.post('/pandugenre', {
    onSuccess: () => {
      step.value = 1
      form.reset()
    }
  })
}
</script>

<template>
    <Head title="Tambah Data Catin" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 space-y-4">
            <h1 class="text-xl font-bold">Tambah Pandu Genre</h1>

            <!-- Step 1: Cari NIK Baduta -->
            <div v-if="step === 1">
            <label for="nik">Masukkan NIK Baduta:</label>
            <input v-model="searchNIK" type="text" class="border p-2 rounded w-full" />
            <button @click="checkNIK" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
            <p v-if="error" class="text-red-600 mt-2">{{ error }}</p>
            </div>

            <!-- Konfirmasi jika tidak stunting -->
            <div v-if="showConfirmation" class="bg-yellow-100 border p-4 rounded">
            <p>Baduta tidak teridentifikasi sebagai stunting. Apakah ingin tetap menambahkan?</p>
            <button @click="confirmNonStunting" class="bg-green-600 text-white px-4 py-1 mt-2 rounded">Ya, lanjutkan</button>
            </div>

            <!-- Step 2: Form Terapi -->
            <div v-if="step === 2 && allowContinue">
            <h2 class="font-semibold">Form Terapi</h2>

            <div class="space-y-2">
                <label>Terapi Gizi</label>
                <input v-model="form.terapi_gizi" class="w-full border p-2 rounded" />
                <label>Terapi Gizi</label>
                <input v-model="form.terapi_gizi" class="w-full border p-2 rounded" />
                <label>Terapi Gizi</label>
                <input v-model="form.terapi_gizi" class="w-full border p-2 rounded" />

                <label>Terapi Psikososial</label>
                <input v-model="form.terapi_psikososial" class="w-full border p-2 rounded" />

                <label>Kunjungan Rumah</label>
                <input v-model="form.kunjungan_rumah" class="w-full border p-2 rounded" />

                <button @click="submit" class="bg-green-600 text-white px-4 py-2 rounded mt-4">Simpan</button>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
