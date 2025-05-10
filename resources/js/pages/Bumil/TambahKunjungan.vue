<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
  penduduk_nik: string;
  nama: string;
}>();

const showForm = ref(false);

const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];

const fasilitasBABOptions = [
  "Jamban sehat", "Jamban tidak sehat", "Tidak ada"
];

// Form kunjungan untuk ibu hamil
const kunjunganForm = ref({
  tanggal: '',
  usia_kehamilan: '',
  TUF: '',
  tinggi_badan: '',
  berat_badan_sebelum_hamil: '',
  berat_badan_saat_ini: '',
  indeks_massa_tubuh: '',
  kadar_hemoglobin: '',
  LILA: '',
  menggunakan_alat_kontrasepsi: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  meerokok_terpapar: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_table_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
});

function submitKunjungan() {
  router.post('/kunjunganbumil', {
    penduduk_nik: props.penduduk_nik,
    ...kunjunganForm.value,
  }, {
    onSuccess: () => {
      router.visit(`/bumil/${props.penduduk_nik}`);
    },
    onError: (errors) => {
      console.error('Error submitting form:', errors);
    }
  });
}
</script>

<template>
  <div>
    <div v-if="showForm" class="mt-4 border p-4 rounded bg-gray-50">
      <h3 class="font-semibold mb-2">Form Kunjungan Ibu Hamil</h3>

      <div class="mb-4">
        <p><strong>NIK:</strong> {{ props.penduduk_nik }}</p>
        <p><strong>Nama Ibu:</strong> {{ props.nama }}</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm mb-1">Tanggal Kunjungan</label>
          <input type="date" v-model="kunjunganForm.tanggal" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Usia Kehamilan (minggu)</label>
          <input type="number" v-model="kunjunganForm.usia_kehamilan" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Taksiran Usia Fetus (TUF)</label>
          <input type="text" v-model="kunjunganForm.TUF" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Tinggi Badan (cm)</label>
          <input type="number" v-model="kunjunganForm.tinggi_badan" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Berat Badan Sebelum Hamil (kg)</label>
          <input type="number" v-model="kunjunganForm.berat_badan_sebelum_hamil" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Berat Badan Saat Ini (kg)</label>
          <input type="number" v-model="kunjunganForm.berat_badan_saat_ini" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Indeks Massa Tubuh (IMT)</label>
          <input type="number" v-model="kunjunganForm.indeks_massa_tubuh" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Kadar Hemoglobin (g/dL)</label>
          <input type="number" v-model="kunjunganForm.kadar_hemoglobin" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">LILA (cm)</label>
          <input type="number" v-model="kunjunganForm.LILA" step="0.1" class="w-full border px-2 py-1 rounded" />
        </div>

        <!-- Radio options -->
        <div>
          <label class="block text-sm mb-1">Menggunakan Alat Kontrasepsi</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.menggunakan_alat_kontrasepsi" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.menggunakan_alat_kontrasepsi" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Sumber Air Minum</label>
          <select v-model="kunjunganForm.sumber_air_minum" class="w-full border px-2 py-1 rounded">
            <option value="" disabled>Pilih</option>
            <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <div>
          <label class="block text-sm mb-1">Fasilitas BAB</label>
          <select v-model="kunjunganForm.fasilitas_BAB" class="w-full border px-2 py-1 rounded">
            <option value="" disabled>Pilih</option>
            <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>
        <div>
          <label class="block text-sm mb-1">Terpapar Asap Rokok</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.meerokok_terpapar" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.meerokok_terpapar" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Mendapatkan Tablet Tambah Darah</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.mendapatkan_tablet_tambah_darah" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.mendapatkan_tablet_tambah_darah" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Meminum Tablet Tambah Darah</label>
          <label><input type="radio" value="Ya" v-model="kunjunganForm.meminum_table_tambah_darah" /> Ya</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.meminum_table_tambah_darah" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Penyuluhan KIE</label>
          <label><input type="radio" value="Ya, perorang" v-model="kunjunganForm.penyuluhan_KIE" /> Ya, perorang</label>
          <label><input type="radio" value="Ya, kelompok" v-model="kunjunganForm.penyuluhan_KIE" /> Ya, kelompok</label>
          <label><input type="radio" value="Tidak" v-model="kunjunganForm.penyuluhan_KIE" /> Tidak</label>
        </div>
        <div>
          <label class="block text-sm mb-1">Fasilitas Layanan Rujukan</label>
          <input type="text" v-model="kunjunganForm.fasilitas_layanan_rujukan" class="w-full border px-2 py-1 rounded" />
        </div>
        <div>
          <label class="block text-sm mb-1">Bantuan Sosial</label>
          <label><input type="radio" value="Ya, sedang di proses" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Ya, sedang di proses</label>
          <label><input type="radio" value="Ya, sudah mendapat bantuan sosial" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Ya, sudah mendapat</label>
          <label><input type="radio" value="Tidak, karena tidak memenuhi syarat" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Tidak, tidak memenuhi syarat</label>
          <label><input type="radio" value="Tidak, karena sudah menerima bantuan" v-model="kunjunganForm.fasilitas_bantuan_sosial" /> Tidak, sudah menerima</label>
        </div>
      </div>

      <button @click="submitKunjungan" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Simpan Kunjungan
      </button>
    </div>

    <button v-else @click="showForm = !showForm" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      Tambah Kunjungan
    </button>
  </div>
</template>
