CREATE.VUE BADUTA NORMAL
<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BreadcrumbItem } from '@/types';
import axios from 'axios'; // pastikan ini diimport

// Ambil 'nik' dari URL (query param)
const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Baduta TPK',
    href: '/baduta/create',
  },
];

const step = ref(1);
const errors = ref<string[]>([]);

// Opsi dropdown
const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];
const fasilitasBABOptions = [
  "Jamban milik sendiri", "Jamban pada MCK", "Lainnya", "Tidak Ada"
];

// Form state
const form = useForm({
  penduduk_ibu_nik: '',
  jumlah_anak_kandung: 0,
  tanggal_lahir_anak_terakhir: '',
  menggunakan_alat_kontrasepsi: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  berat_badan: null,
  tinggi_badan: null,
  urutan_anak: null,
  umur_kehamilan_saat_lahir: null,
  asi_eksklusif: '',
  imunisasi_hepatitis_B: '',
  merokok_terpapar: '',
  mengisi_KKA: '',
  longitude: '',
  latitude: '',
  kehadiran_posyandu: '',
  penyuluhan_KIE: '',
  fasilitas_bantuan_sosial: '',
  stunting: '',
  penduduk_nik: penduduk_nik.value,
});
const namaIbu = ref<string>('');
const checkNIK = async () => {
  try {
    const response = await axios.post('/cek-nik', {
      nik: form.penduduk_ibu_nik
    });

    if (response.data.status === 'data ada') {
      namaIbu.value = response.data.nama;
    } else {
      namaIbu.value = '';
      alert("Data tidak ada");
    }
  } catch (error: unknown) {
    namaIbu.value = '';
    if (axios.isAxiosError(error)) {
      alert("Terjadi kesalahan: " + error.message);
    } else {
      alert("Terjadi kesalahan tidak diketahui");
    }
  }
};

// Submit
const submitForm = () => {
  errors.value = [];

  form.post('/baduta', {
    onSuccess: () => {
      window.location.href = '/penduduk';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>

<template>
  <Head title="Penduduk TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Penduduk Baduta</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <!-- Step 1 -->
        <div v-if="step === 1">
          <h2>Data Ibu</h2>
          <div>
            <label>NIK Ibu:</label>
            <input v-model="form.penduduk_ibu_nik" type="text" />
            <button type="button" @click="checkNIK">Cek</button>
            <!-- ✅ Tampilkan nama ibu -->
            <p v-if="namaIbu"><strong>Nama Ibu:</strong> {{ namaIbu }}</p>
        </div>
          <div>
            <label>Jumlah Anak Kandung:</label>
            <input v-model.number="form.jumlah_anak_kandung" type="number" required />
          </div>
          <div>
            <label>Tanggal Lahir Anak Terakhir:</label>
            <input v-model="form.tanggal_lahir_anak_terakhir" type="date" required />
          </div>
          <div>
            <label>Menggunakan Kontrasepsi Saat Ini?</label><br>
            <label><input type="radio" value="Ya" v-model="form.menggunakan_alat_kontrasepsi" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.menggunakan_alat_kontrasepsi" /> Tidak</label>
          </div>
          <div>
            <label>Sumber Air Minum Utama:</label>
            <select v-model="form.sumber_air_minum">
              <option value="" disabled>Pilih</option>
              <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <div>
            <label>Fasilitas Buang Air Besar:</label>
            <select v-model="form.fasilitas_BAB">
              <option value="" disabled>Pilih</option>
              <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
            </select>
          </div>
          <button type="button" @click="step++">Next</button>
        </div>

        <!-- Step 2 -->
        <div v-if="step === 2">
          <h2>Data Baduta</h2>
          <div><label>NIK Anak (dari URL):</label><input v-model="form.penduduk_nik" type="text" disabled /></div>
          <div><label>Berat Badan (kg):</label><input v-model.number="form.berat_badan" type="number" step="0.01" required /></div>
          <div><label>Tinggi Badan (cm):</label><input v-model.number="form.tinggi_badan" type="number" step="0.1" required /></div>
          <div><label>Urutan Anak:</label><input v-model.number="form.urutan_anak" type="number" required /></div>
          <div><label>Umur Kehamilan Saat Lahir (minggu):</label><input v-model.number="form.umur_kehamilan_saat_lahir" type="number" required /></div>
          <div>
            <label>ASI Eksklusif?</label><br>
            <label><input type="radio" value="Ya" v-model="form.asi_eksklusif" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.asi_eksklusif" /> Tidak</label>
          </div>
          <div>
            <label>Imunisasi Hepatitis B?</label><br>
            <label><input type="radio" value="Ya" v-model="form.imunisasi_hepatitis_B" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.imunisasi_hepatitis_B" /> Tidak</label>
          </div>
          <div>
            <label>Terpapar Rokok?</label><br>
            <label><input type="radio" value="Ya" v-model="form.merokok_terpapar" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.merokok_terpapar" /> Tidak</label>
          </div>
          <div>
            <label>Mengisi KKA?</label><br>
            <label><input type="radio" value="Ya" v-model="form.mengisi_KKA" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.mengisi_KKA" /> Tidak</label>
          </div>
          <button type="button" @click="step--">Back</button>
          <button type="button" @click="step++">Next</button>
        </div>

        <!-- Step 3 -->
        <div v-if="step === 3">
          <h2>Data Pendampingan Bulanan</h2>
          <div><label>Longitude:</label><input v-model="form.longitude" type="text" required /></div>
          <div><label>Latitude:</label><input v-model="form.latitude" type="text" required /></div>
          <div>
            <label>Kehadiran Posyandu?</label><br>
            <label><input type="radio" value="Ya" v-model="form.kehadiran_posyandu" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.kehadiran_posyandu" /> Tidak</label>
          </div>
          <div>
            <label>Penyuluhan/KIE:</label><br>
            <label><input type="radio" value="Ya, perorang" v-model="form.penyuluhan_KIE" /> Ya, perorang</label>
            <label><input type="radio" value="Ya, kelompok" v-model="form.penyuluhan_KIE" /> Ya, kelompok</label>
            <label><input type="radio" value="Tidak" v-model="form.penyuluhan_KIE" /> Tidak</label>
          </div>
          <div>
            <label>Bantuan Sosial:</label><br>
            <label><input type="radio" value="Ya, sedang di proses" v-model="form.fasilitas_bantuan_sosial" /> Ya, sedang di proses</label>
            <label><input type="radio" value="Ya, sudah mendapat bantuan sosial" v-model="form.fasilitas_bantuan_sosial" /> Ya, sudah mendapat</label>
            <label><input type="radio" value="Tidak, karena tidak memenuhi syarat" v-model="form.fasilitas_bantuan_sosial" /> Tidak, tidak memenuhi syarat</label>
            <label><input type="radio" value="Tidak, karena sudah menerima bantuan" v-model="form.fasilitas_bantuan_sosial" /> Tidak, sudah menerima</label>
          </div>
          <div>
            <label>Anak Mengalami Stunting?</label><br>
            <label><input type="radio" value="Ya" v-model="form.stunting" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.stunting" /> Tidak</label>
          </div>
          <button type="button" @click="step--">Back</button>
          <button type="submit">Simpan Data</button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
input, select {
  display: block;
  margin-bottom: 10px;
  width: 100%;
}
label {
  font-weight: 500;
}
button {
  margin-right: 10px;
  margin-top: 15px;
}
</style>
