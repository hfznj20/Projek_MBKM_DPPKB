<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BreadcrumbItem } from '@/types';
import Modal from '@/components/Modal.vue';
import axios from 'axios';

// Ambil 'nik' dari URL (query param)
const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Catin', href: '/catin/create' },
];

// Opsi dropdown
const sumberAirOptions = [
  "Air kemasan/Isi ulang", "Ledeng/PAM", "Sumur bor/Pompa", "Sumur terlindungi",
  "Sumur tak terlindungi", "Mata air terlindungi", "Mata air tak terlindungi",
  "Air permukaan (sungai/danau/waduk/kolam/irigasi)", "Air hujan", "Lainnya"
];

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';


const fasilitasBABOptions = [
  "Jamban milik sendiri dengan leher angsa dan tangki septik/IPAL",
  "Jamban pada MCK komunal dengan eher angsa dan tangki/septik/IPAL", "Lainnya", "Tidak ada"
];

const onKecamatanChange = () => {
  const selected = formPasangan.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const kelurahanOptions = ref<string[]>([]);

// Form state untuk Catin
const form = useForm({
  nik_catin1: '',
  nik_catin2: '',
  nama: '',
  tanggal_pernikahan: '',
  tinggi_badan: 0,
  berat_badan: 0,
  indeks_massa_tubuh: 0,
  kadar_hemoglobin: 0,
  LILA: 0,
  menggunakan_alat_kontrasepsi: '',
  catin_wanita_merokok_terpapar: '',
  catin_pria_merokok_terpapar: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_tablet_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
  stunting: '',
  penduduk_nik: penduduk_nik.value,
});

// Form state untuk Pasangan Baru
const formPasangan = useForm({
  nik: '',
  nama: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  kecamatan: '' ,
  kelurahan: '',
  RT: '',
  RW: '',
  alamat: '',
  no_hp: '',
  kategori: 'Catin'
});

const errors = ref<string[]>([]);
const showModal = ref(false);
const namaPasangan = ref<string>('');

// Step Control
const step = ref(1);

// Cek data pasangan
const checkPasangan = async () => {
  try {
    const response = await axios.post('/cek-nik', {
      nik: form.nik_catin1
    });

    if (response.data.status === 'data ada') {
      namaPasangan.value = response.data.nama;
      form.nik_catin2 = response.data.nik;
      // step.value = 2;  // Proceed to Step 2 if the partner is found
    } else {
      namaPasangan.value = '';
      alert("Data pasangan tidak ditemukan. Anda dapat menambah data pasangan baru.");
      showModal.value = true; // Show modal to add new partner data
    }
  } catch (error: unknown) {
    namaPasangan.value = '';
    if (axios.isAxiosError(error)) {
      alert("Terjadi kesalahan: " + error.message);
    } else {
      alert("Terjadi kesalahan tidak diketahui");
    }
  }
};

// Submit data pasangan baru
const submitPasangan = async () => {
  console.log(formPasangan);
  formPasangan.post('/penduduk', {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      form.nik_catin2 = formPasangan.nik;
      namaPasangan.value = formPasangan.nama;
      showModal.value = false;
      step.value = 1;
    },
    onError: () => {
      console.log('gagal');
    }
  })
  // try {
  //   await axios.post('/penduduk', formPasangan);
  //   alert('Data pasangan berhasil disimpan!');
  //   showModal.value = false; // Menutup modal setelah data disimpan
  //   step.value = 2; // Proceed to Step 2 after saving the partner data
  // } catch (error: any) {
  //   alert("Terjadi kesalahan saat menyimpan data pasangan: " + error.message);
  // }
};

// Submit Form Catin
const submitForm = () => {
  errors.value = [];
  form.post('/catin', {
    onSuccess: () => {
      window.location.href = '/penduduk';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};

// Go to next step
const nextStep = () => {
  step.value++;
};

// Go to previous step
const prevStep = () => {
  step.value--;
};

const goToFormPendudukBaru = () => {
  showModal.value = true; // Menampilkan modal untuk input data pasangan
};

</script>

<template>
  <Head title="Tambah Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Catin</h2>

      <!-- Error Message -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <!-- Step 1: Data Catin -->
      <div v-if="step === 1">
        <h3>Data Catin</h3>
      
        <!-- NIK Catin -->
      <div class="mb-3">
        <label class="form-label">NIK Catin</label>
        <input type="text" v-model="form.penduduk_nik" class="form-control" disabled />
      </div>

      <!-- Nama Catin -->
      <div class="mb-3">
        <label class="form-label">Nama Catin</label>
        <input type="text" v-model="form.nama" class="form-control" disabled />
      </div>

        <div class="mb-3">
          <label class="form-label">NIK Pasangan</label>
          <input v-model="form.nik_catin1" type="text" class="form-control" placeholder="Masukkan NIK Pasangan" maxlength="16"/>
          <button type="button" @click="checkPasangan" class="btn btn-info mt-2">Cek Data Pasangan</button>
        </div>

        <div v-if="namaPasangan">
          <p><strong>Nama Pasangan:</strong> {{ namaPasangan }}</p>
        </div>

        <div v-if="!namaPasangan">
          <button type="button" @click="goToFormPendudukBaru" class="btn btn-warning">Tambah Pasangan Baru</button>
        </div>

        <button class="btn btn-primary mt-3" @click="nextStep" :disabled="!namaPasangan">Next</button>
      </div>

      <!-- Step 2: Form Data Kesehatan Catin -->
      <div v-if="step === 2">
        <h3>Form Data Kesehatan Catin</h3>
        <div class="mb-3">
          <label class="form-label">Tanggal Pernikahan</label>
          <input v-model="form.tanggal_pernikahan" type="date" class="form-control" required />
        </div>
        
        <div class="mb-3">
          <label class="form-label">Tinggi Badan</label>
          <input v-model="form.tinggi_badan" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Berat Badan</label>
          <input v-model="form.berat_badan" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Indeks Massa Tubuh (IMT)</label>
          <input v-model="form.indeks_massa_tubuh" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Kadar Hemoglobin</label>
          <input v-model="form.kadar_hemoglobin" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Lingkar Lengan Atas</label>
          <input v-model="form.LILA" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Apakah Catin Wanita merokok/terpapar rokok?</label>
          <select v-model="form.catin_wanita_merokok_terpapar" class="form-control">
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Sumber Air Minum Utama</label>
          <select v-model="form.sumber_air_minum" class="form-control">
            <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Fasilitas Buang Air Besar</label>
          <select v-model="form.fasilitas_BAB" class="form-control">
            <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>

        <button type="button" @click="prevStep" class="btn btn-secondary">Back</button>
        <button type="button" @click="nextStep" class="btn btn-primary">Next</button>
      </div>

      <!-- Step 3: Data Pendampingan Bulanan -->
      <div v-if="step === 3">
        <h3>Data Pendampingan</h3>
        <div class="mb-3">
          <label class="form-label">Longitude</label>
          <input v-model="form.longitude" type="text" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Latitude</label>
          <input v-model="form.latitude" type="text" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">stunting</label>
          <select v-model="form.stunting" class="form-control">
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <button type="button" @click="prevStep" class="btn btn-secondary">Back</button>
        <button type="submit" class="btn btn-success" @click="submitForm">Simpan Data</button>
      </div>

      <!-- Modal Untuk Input Data Pasangan -->
      <Modal v-model:show="showModal">
        <h3>Tambah Data Pasangan Baru</h3>
        <form @submit.prevent="submitPasangan">
          <div class="mb-3">
            <label class="form-label">NIK Pasangan</label>
            <input v-model="formPasangan.nik" type="text" class="form-control" maxlength="16" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Pasangan</label>
            <input v-model="formPasangan.nama" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input v-model="formPasangan.tanggal_lahir" type="date" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select v-model="formPasangan.jenis_kelamin" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          
          <div class="mb-3">
          <label for="kecamatan" class="form-label">Kecamatan</label>
          <select v-model="formPasangan.kecamatan" @change="onKecamatanChange" class="form-select" id="kecamatan" required>
            <option value="">-- Pilih --</option>
            <option value="Ujung">Ujung</option>
            <option value="Bacukiki">Bacukiki</option>
            <option value="Bacukiki Barat">Bacukiki Barat</option>
            <option value="Soreang">Soreang</option>
          </select>
        </div>
        
        <div class="mb-3">
          <label for="kelurahan" class="form-label">Kelurahan</label>
          <select v-model="formPasangan.kelurahan" class="form-select" id="kelurahan" required>
            <option value="">-- Pilih Kelurahan --</option>
            <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
              {{ kelurahan }}
            </option>
          </select>
        </div>

          <div class="mb-3">
            <label class="form-label">RT</label>
            <input v-model="formPasangan.RT" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">RW</label>
            <input v-model="formPasangan.RW" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <textarea v-model="formPasangan.alamat" id="alamat" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="no_hp" class="form-label">No HP</label>
          <input v-model="formPasangan.no_hp" type="text" class="form-control" id="no_hp" required />
        </div>
          <button type="submit" class="btn btn-success">Simpan Data</button>
      </form>
      </Modal>

    </div>
  </AppLayout>
</template>

<style scoped>
/* Styling */
input, select, button {
  display: block;
  margin-bottom: 10px;
  width: 100%;
}
label {
  font-weight: 500;
}
button {
  margin-top: 15px;
}
</style>
