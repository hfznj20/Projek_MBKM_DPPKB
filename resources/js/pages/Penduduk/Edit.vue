<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';
import { router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

const props = defineProps<{
  penduduk: {
    nik: string;
    nama: string;
    tanggal_lahir: string;
    jenis_kelamin: string;
    kecamatan: Kecamatan;
    kelurahan: string;
    RT: string;
    RW: string;
    alamat: string;
    no_hp: string;
    kategori: string;
  };
}>();


const form = useForm({
  nik: props.penduduk.nik,
  nama: props.penduduk.nama,
  tanggal_lahir: props.penduduk.tanggal_lahir,
  jenis_kelamin: props.penduduk.jenis_kelamin,
  kecamatan: props.penduduk.kecamatan,
  kelurahan: props.penduduk.kelurahan,
  RT: props.penduduk.RT,
  RW: props.penduduk.RW,
  alamat: props.penduduk.alamat,
  no_hp: props.penduduk.no_hp,
  kategori: props.penduduk.kategori,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Edit Data Penduduk',
    href: `/penduduk/${props.penduduk.nik}/edit`,
  },
];


const kelurahanOptions = ref<string[]>([]);

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const onKecamatanChange = () => {
  const selected = form.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

// Isi kelurahan saat pertama kali mount
onMounted(() => {
  onKecamatanChange();
});

const errors = ref<string[]>([]);
const submitForm = () => {
  form.put(`/penduduk/${form.nik}`, {
    onSuccess: () => {
      const kategori = form.kategori.toLowerCase().replace(/\s+/g, '-');
      Inertia.visit(`/${kategori}/create?nik=${form.nik}`);
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>

<template>
  <Head title="Edit Penduduk" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Edit Data Penduduk</h2>

      <form @submit.prevent="submitForm">
        <div class="mb-3">
          <label for="nama" class="form-label">NIK</label>
          <input v-model="form.nik" type="text" class="form-control" id="nik" readonly />
        </div>

        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input v-model="form.nama" type="text" class="form-control" id="nama" required />
        </div>

        <div class="mb-3">
          <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
          <input v-model="form.tanggal_lahir" type="date" class="form-control" id="tanggal_lahir" required />
        </div>

        <div class="mb-3">
          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
          <select v-model="form.jenis_kelamin" class="form-select" id="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="kecamatan" class="form-label">Kecamatan</label>
          <select v-model="form.kecamatan" @change="onKecamatanChange" class="form-select" id="kecamatan" required>
            <option value="">-- Pilih --</option>
            <option value="Ujung">Ujung</option>
            <option value="Bacukiki">Bacukiki</option>
            <option value="Bacukiki Barat">Bacukiki Barat</option>
            <option value="Soreang">Soreang</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="kelurahan" class="form-label">Kelurahan</label>
          <select v-model="form.kelurahan" class="form-select" id="kelurahan" required>
            <option value="">-- Pilih Kelurahan --</option>
            <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
              {{ kelurahan }}
            </option>
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="RT" class="form-label">RT</label>
            <input v-model="form.RT" type="text" id="RT" class="form-control" required />
          </div>
          <div class="col-md-6 mb-3">
            <label for="RW" class="form-label">RW</label>
            <input v-model="form.RW" type="text" id="RW" class="form-control" required />
          </div>
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea v-model="form.alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="no_hp" class="form-label">No HP</label>
          <input v-model="form.no_hp" type="text" class="form-control" id="no_hp" required />
        </div>

        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <select v-model="form.kategori" class="form-select" id="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Penduduk">Penduduk</option>
            <option value="BADUTA">BADUTA</option>
            <option value="BUMIL">BUMIL</option>
            <option value="Pasca Persalinan">Pasca Persalinan</option>
            <option value="CATIN">CATIN</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <button type="button" class="btn btn-secondary" @click="router.visit('/penduduk')">Batal</button>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahkan styling tambahan jika diperlukan */
</style>
