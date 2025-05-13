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
  kelurahanOptions.value = form.kecamatan && kelurahanMap[form.kecamatan as Kecamatan]
    ? kelurahanMap[form.kecamatan as Kecamatan]
    : [];
};

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
    <div class="p-6 bg-white rounded shadow mx-4 md:mx-7 mt-7">
      <div v-if="errors.length" class="bg-red-100 text-red-700 p-4 rounded mb-4 text-sm font-normal">
        <ul class="list-disc list-inside">
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-4">
            <div>
              <label class="block font-normal text-sm">NIK:</label>
              <input v-model="form.nik" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" readonly />
            </div>

            <div>
              <label class="block font-normal text-sm">Nama:</label>
              <input v-model="form.nama" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
            </div>

            <div>
              <label class="block font-normal text-sm">Tanggal Lahir:</label>
              <input v-model="form.tanggal_lahir" type="date" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
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
              <label class="block font-normal text-sm">Alamat:</label>
              <textarea v-model="form.alamat" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" rows="3" required></textarea>
            </div>
          </div>

          <div class="space-y-4">
            <div>
              <label class="block font-normal text-sm">Kecamatan:</label>
              <select v-model="form.kecamatan" @change="onKecamatanChange" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required>
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
              <label class="block font-normal text-sm">No HP:</label>
              <input v-model="form.no_hp" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm font-normal" required />
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
          <button type="button" class="bg-red-600 hover:bg-red-700 text-white text-sm font-normal px-4 py-1 rounded shadow mr-2" @click="router.visit('/penduduk')">
            Batal
          </button>
          <button type="submit" class="bg-[#2F2E81] hover:bg-[#1f1e5e] text-white text-sm font-normal px-4 py-1 rounded shadow">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahkan styling tambahan jika diperlukan */
</style>