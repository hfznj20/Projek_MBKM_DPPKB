<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

const form = useForm({
  nik: '',
  nama: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  kecamatan: '' as Kecamatan | '',
  kelurahan: '',
  RT: '',
  RW: '',
  alamat: '',
  no_hp: '',
  kategori: ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Penduduk', href: '/penduduk/create' },
];

const errors = ref<string[]>([]);
const kelurahanOptions = ref<string[]>([]);

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const onKecamatanChange = () => {
  kelurahanOptions.value = form.kecamatan ? kelurahanMap[form.kecamatan as Kecamatan] : [];
};

// Pantau kecamatan secara otomatis jika user mengganti
watch(() => form.kecamatan, onKecamatanChange);

const submitForm = () => {
  form.post('/penduduk', {
    onSuccess: () => {
      const kategori = form.kategori.toLowerCase().replace(/\s+/g, '-');
      if (kategori && form.nik) {
        Inertia.visit(`/${kategori}/create?nik=${form.nik}`);
      }
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>

<template>
  <Head title="Data Penduduk" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">

      <div v-if="errors.length" class="bg-red-100 text-red-700 p-4 rounded mb-4 text-sm font-normal">
        <ul class="list-disc list-inside">
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <div class="bg-white shadow rounded p-4">
        <form @submit.prevent="submitForm">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-4">
              <div>
                <label class="block font-normal text-sm">Nama:</label>
                <input v-model="form.nama" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
              </div>

              <div>
                <label class="block font-normal text-sm">NIK:</label>
                <input v-model="form.nik" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" maxlength="16" required />
              </div>

              <div>
                <label class="block font-normal text-sm">Jenis Kelamin:</label>
                <select v-model="form.jenis_kelamin" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required>
                  <option value="">-- Pilih --</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>

              <div>
                <label class="block font-normal text-sm">Tanggal Lahir:</label>
                <input v-model="form.tanggal_lahir" type="date" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
              </div>

              <div>
                <label class="block font-normal text-sm">Alamat:</label>
                <textarea v-model="form.alamat" class="w-full border border-orange-500 rounded px-3 py-6 text-sm font-normal" rows="2" required></textarea>
              </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-4">
              <div>
                <label class="block font-normal text-sm">Kecamatan:</label>
                <select v-model="form.kecamatan" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required>
                  <option value="">-- Pilih --</option>
                  <option value="Ujung">Ujung</option>
                  <option value="Bacukiki">Bacukiki</option>
                  <option value="Bacukiki Barat">Bacukiki Barat</option>
                  <option value="Soreang">Soreang</option>
                </select>
              </div>

              <div>
                <label class="block font-normal text-sm">Kelurahan:</label>
                <select v-model="form.kelurahan" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required>
                  <option value="">-- Pilih Kelurahan --</option>
                  <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
                    {{ kelurahan }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block font-normal text-sm">RT:</label>
                <input v-model="form.RT" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
              </div>

              <div>
                <label class="block font-normal text-sm">RW:</label>
                <input v-model="form.RW" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
              </div>

              <div>
                <label class="block font-normal text-sm">No Telepon:</label>
                <input
                  v-model="form.no_hp"
                  type="text"
                  class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal"
                  pattern="^\+62\d{10,12}$"
                  minlength="12"
                  placeholder="Contoh: +6281234567890"
                  required
                />
                <p v-if="form.no_hp && !form.no_hp.match(/^\+62\d{10,12}$/)" class="text-red-600 text-xs mt-1">
                  Nomor telepon harus dimulai dengan +62 dan memiliki minimal 12 digit.
                </p>
              </div>

              <div>
                <label class="block font-normal text-sm">Kategori:</label>
                <select v-model="form.kategori" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required>
                  <option value="">-- Pilih Kategori --</option>
                  <option value="Penduduk">Penduduk</option>
                  <option value="BADUTA">BADUTA</option>
                  <option value="BUMIL">BUMIL</option>
                  <option value="Pasca Persalinan">Pasca Persalinan</option>
                  <option value="CATIN">CATIN</option>
                </select>
              </div>
            </div>
          </div>

          <div class="mt-6 text-end">
            <button type="submit" class="bg-[#2F2E81] hover:bg-[#1f1e5e] text-white text-sm font-normal px-4 py-1 rounded shadow">
              Berikutnya
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>
