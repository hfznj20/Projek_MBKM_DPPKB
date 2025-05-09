<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  penduduk_nik: string;
  nama: string; // Menambahkan properti untuk nama
}>();

const showForm = ref(false);

const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];

// Menambahkan semua field untuk form kunjungan
const kunjunganForm = ref({
  tanggal: '',
  berat_badan: '',
  tinggi_badan: '',
  menggunakan_alat_kontrasepsi: '',
  sumber_air_minum: '',
  asi_eksklusif: '',
  imunisasi_hepatitis_B: '',
  merokok_terpapar: '',
  mengisi_KKA: '',
  kehadiran_posyandu: '',
  penyuluhan_KIE: '',
  fasilitas_bantuan_sosial: '',
});

function submitKunjungan() {
  // Mengirim semua data dari form kunjungan
  router.post('/kunjungan', {
    penduduk_nik: props.penduduk_nik,
    tanggal: kunjunganForm.value.tanggal,
    berat_badan: kunjunganForm.value.berat_badan,
    tinggi_badan: kunjunganForm.value.tinggi_badan,
    menggunakan_alat_kontrasepsi: kunjunganForm.value.menggunakan_alat_kontrasepsi,
    sumber_air_minum: kunjunganForm.value.sumber_air_minum,
    asi_eksklusif: kunjunganForm.value.asi_eksklusif,
    imunisasi_hepatitis_B: kunjunganForm.value.imunisasi_hepatitis_B,
    merokok_terpapar: kunjunganForm.value.merokok_terpapar,
    mengisi_KKA: kunjunganForm.value.mengisi_KKA,
    kehadiran_posyandu: kunjunganForm.value.kehadiran_posyandu,
    penyuluhan_KIE: kunjunganForm.value.penyuluhan_KIE,
    fasilitas_bantuan_sosial: kunjunganForm.value.fasilitas_bantuan_sosial,
  }, {
    onSuccess: () => {
      router.visit(`/baduta/${props.penduduk_nik}`);
    },
    onError: (errors) => {
      console.error('Error submitting form:', errors);
    }
  });
}
</script>

<template>
  <div>
    <!-- Form untuk memasukkan data kunjungan -->
    <div v-if="showForm" class="mt-4 border p-4 rounded bg-gray-50">
      <h3 class="font-semibold mb-2">Form Pendampingan</h3>
      
      <!-- Tampilkan NIK dan Nama Baduta -->
      <div class="mb-4">
        <p><strong>NIK:</strong> {{ props.penduduk_nik }}</p>
        <p><strong>Nama Baduta:</strong> {{ props.nama }}</p>
      </div>
      
      <!-- Form input untuk kunjungan -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm mb-1">Tanggal Kunjungan</label>
          <input type="date" v-model="kunjunganForm.tanggal" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Berat Badan (kg)</label>
          <input type="number" v-model="kunjunganForm.berat_badan" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Tinggi Badan (cm)</label>
          <input type="number" v-model="kunjunganForm.tinggi_badan" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Menggunakan Alat Kontrasepsi</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.menggunakan_alat_kontrasepsi" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.menggunakan_alat_kontrasepsi" /> Tidak</label>

        </div>
        <div>
          <label class="block text-sm mb-1">Sumber Air Minum</label>
          <select v-model="kunjunganForm.sumber_air_minum">
            <option value="" disabled>Pilih</option>
            <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <div>
          <label class="block text-sm mb-1">ASI Eksklusif</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.asi_eksklusif" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.asi_eksklusif" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Imunisasi Hepatitis B</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.imunisasi_hepatitis_B" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.imunisasi_hepatitis_B" /> Tidak</label>        </div>
        <div>
          <label class="block text-sm mb-1">Merokok Terpapar</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.merokok_terpapar" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.merokok_terpapar" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Mengisi KKA</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.mengisi_KKA" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.mengisi_KKA" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Kehadiran Posyandu</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.kehadiran_posyandu" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.kehadiran_posyandu" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Penyuluhan KIE</label>
          <label><input type="radio" value="Ya, perorang" v-model="kunjunganForm.penyuluhan_KIE" /> Ya, perorang</label>
          <label><input type="radio" value="Ya, kelompok" v-model="kunjunganForm.penyuluhan_KIE" /> Ya, kelompok</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.penyuluhan_KIE" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Bantuan Sosial</label>
          <label><input type="radio" value="Ya, sedang di proses" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Ya, sedang di proses</label>
          <label><input type="radio" value="Ya, sudah mendapat bantuan sosial" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Ya, sudah mendapat</label>
          <label><input type="radio" value="Tidak, karena tidak memenuhi syarat" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Tidak, tidak memenuhi syarat</label>
          <label><input type="radio" value="Tidak, karena sudah menerima bantuan" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Tidak, sudah menerima</label>
        </div>
      </div>

      <!-- Tombol untuk submit form -->
      <button @click="submitKunjungan" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Simpan Kunjungan
      </button>
    </div>

    <!-- Tombol untuk menampilkan form -->
    <button v-else @click="showForm = !showForm" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      Tambah Kunjungan
    </button>
  </div>
</template>
