<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head } from '@inertiajs/vue3';

interface CatinData {
  penduduk_id: number;
  nama: string;
  jenis_kelamin: string;
  tanggal_lahir: string;
  kelurahan: string;
  kecamatan: string;
  RT: string;
  RW: string;
  alamat: string;
  tinggi_badan: number;
  berat_badan: number;
  indeks_massa_tubuh: number;
  kadar_hemoglobin: number;
  LILA: number;
  menggunakan_alat_kontrasepsi: string;
  catin_wanita_meerokok_terpapar: string;
  catin_pria_meerokok_terpapar: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  longitude: string;
  latitude: string;
  mendapatkan_tablet_tambah_darah: string;
  meminum_table_tambah_darah: string;
  penyuluhan_KIE: string;
  fasilitas_layanan_rujukan: string;
  fasilitas_bantuan_sosial: string;
}

const router = useRouter();

const catinData = ref<CatinData>({
  penduduk_id: 0,
  nama: '',
  jenis_kelamin: '',
  tanggal_lahir: '',
  kelurahan: '',
  kecamatan: '',
  RT: '',
  RW: '',
  alamat: '',
  tinggi_badan: 0,
  berat_badan: 0,
  indeks_massa_tubuh: 0,
  kadar_hemoglobin: 0,
  LILA: 0,
  menggunakan_alat_kontrasepsi: '',
  catin_wanita_meerokok_terpapar: '',
  catin_pria_meerokok_terpapar: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_table_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
});

const successMessage = ref('');

const nextStep = (step: number) => {
  // Hide all steps first
  document.querySelectorAll('.step').forEach((stepDiv: Element) => {
    (stepDiv as HTMLElement).style.display = 'none';
  });

  // Show the selected step
  const selectedStep = document.getElementById('step' + step);
  if (selectedStep) {
    selectedStep.setAttribute('style', 'display:block');
  }
};

const submitForm = async () => {
  try {
    // Kirim data ke server untuk disimpan
    await router.post('/catin/store', catinData.value);
    successMessage.value = 'Data berhasil disimpan!';
  } catch (error) {
    console.error('Gagal menyimpan data:', error);
  }
};

</script>

<template>
  <Head title="Tambah Data Catin" />

  <div class="container mt-5">
    <h2 class="mb-4">Tambah Data Catin</h2>

    <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

    <!-- Formulir Data Catin -->
    <form @submit.prevent="submitForm">
      <!-- Step 1: Data Catin -->
      <div class="step" id="step1">
        <h2>Data Catin</h2>
        <input type="hidden" v-model="catinData.penduduk_id" />

        <div class="mb-3">
          <label class="form-label">Nama Catin</label>
          <input type="text" v-model="catinData.nama" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis Kelamin</label><br />
          <select v-model="catinData.jenis_kelamin" class="form-control" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" v-model="catinData.tanggal_lahir" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Kelurahan</label>
          <input type="text" v-model="catinData.kelurahan" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Kecamatan</label>
          <select v-model="catinData.kecamatan" class="form-control" required>
            <option value="Ujung">Ujung</option>
            <option value="Bacukiki">Bacukiki</option>
            <option value="Bacukiki Barat">Bacukiki Barat</option>
            <option value="Soreang">Soreang</option>
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">RT</label>
            <input type="text" v-model="catinData.RT" class="form-control" required />
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">RW</label>
            <input type="text" v-model="catinData.RW" class="form-control" required />
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat Lengkap</label>
          <textarea v-model="catinData.alamat" class="form-control" rows="2" required></textarea>
        </div>

        <button type="button" @click="nextStep(2)">Next</button>
      </div>

      <!-- Step 2: Data Kesehatan Catin -->
      <div class="step" id="step2" style="display:none;">
        <h2>Data Kesehatan Catin</h2>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Tinggi Badan (cm)</label>
            <input type="number" v-model="catinData.tinggi_badan" class="form-control" required />
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Berat Badan (kg)</label>
            <input type="number" v-model="catinData.berat_badan" class="form-control" required />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
            <input type="number" v-model="catinData.indeks_massa_tubuh" class="form-control" required />
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Kadar Hemoglobin (Hb)</label>
            <input type="number" v-model="catinData.kadar_hemoglobin" class="form-control" required />
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Lingkar Lengan Atas (LILA) (cm)</label>
          <input type="number" v-model="catinData.LILA" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Apakah Menggunakan Alat Kontrasepsi?</label><br />
          <select v-model="catinData.menggunakan_alat_kontrasepsi" class="form-control">
            <option value="">- Pilih -</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <button type="button" @click="nextStep(1)">Back</button>
        <button type="button" @click="nextStep(3)">Next</button>
      </div>

      <!-- Step 3: Data Pendampingan Bulanan -->
      <div class="step" id="step3" style="display:none;">
        <h2>Data Pendampingan Bulanan</h2>
        <!-- ... (Form input lainnya) ... -->
        <button type="button" @click="nextStep(2)">Back</button>
        <button type="submit" class="btn btn-primary">Simpan Data Catin</button>
      </div>
    </form>
  </div>
</template>
