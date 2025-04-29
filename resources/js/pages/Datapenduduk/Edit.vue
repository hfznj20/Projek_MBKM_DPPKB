<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// Breadcrumbs untuk navigasi
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Edit Data Penduduk',
    href: '/datapenduduk/create',
  },
];

const props = defineProps({
  datapenduduk: Object,
});

// Pastikan props.datapenduduk ada sebelum digunakan
const form = useForm({
  nik: props.datapenduduk?.nik || '',                // Menggunakan optional chaining
  nama_lengkap: props.datapenduduk?.nama_lengkap || '',  // Menggunakan optional chaining
  kecamatan: props.datapenduduk?.kecamatan || '',    // Menggunakan optional chaining
  kelurahan: props.datapenduduk?.kelurahan || '',    // Menggunakan optional chaining
  RT: props.datapenduduk?.RT || '',                  // Menggunakan optional chaining
  RW: props.datapenduduk?.RW || '',                  // Menggunakan optional chaining
  TTL: props.datapenduduk?.TTL || '',                // Menggunakan optional chaining
  jenis_kelamin: props.datapenduduk?.jenis_kelamin || '', // Menggunakan optional chaining
  no_telepon: props.datapenduduk?.no_telepon || '',  // Menggunakan optional chaining
  jalan: props.datapenduduk?.jalan || '',            // Menggunakan optional chaining
  nik_tpk: props.datapenduduk?.nik_tpk || '',        // Menggunakan optional chaining
});

function submit() {
  // Pastikan data ada sebelum mengirimkan data
  if (props.datapenduduk) {
    form.put(route('datapenduduk.update', { nik: props.datapenduduk.nik }), {
      preserveScroll: true,
      onSuccess: () => form.reset(),
      onError: () => console.error("Gagal menyimpan data."),
    });
  } else {
    console.error("Data Penduduk tidak ditemukan.");
  }
}
</script>

<template>
  <Head title="Edit Data Penduduk" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <!-- Tombol Kembali -->
      <div class="flex justify-start mb-2">
        <Link
          href="/datapenduduk"
          class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
        >
          Kembali
        </Link>
      </div>

      <!-- Form untuk Edit Data Penduduk -->
      <form @submit.prevent="submit" class="grid gap-4">
        <!-- NIK Field -->
        <div class="grid gap-2">
          <Label for="nik">NIK:</Label>
          <Input
            id="nik"
            type="text"
            class="mt-1 block w-full bg-gray-100"
            v-model="form.nik"
            placeholder="NIK"
            disabled
          />
          <InputError class="mt-2" :message="form.errors.nik" />
        </div>

        <!-- Nama Lengkap Field -->
        <div class="grid gap-2">
          <Label for="nama_lengkap">Nama Lengkap:</Label>
          <Input
            id="nama_lengkap"
            type="text"
            class="mt-1 block w-full"
            v-model="form.nama_lengkap"
            placeholder="Masukkan nama lengkap"
          />
          <InputError class="mt-2" :message="form.errors.nama_lengkap" />
        </div>

        <!-- Kecamatan Field -->
        <div class="grid gap-2">
          <Label for="kecamatan">Kecamatan:</Label>
          <Input
            id="kecamatan"
            type="text"
            class="mt-1 block w-full"
            v-model="form.kecamatan"
            placeholder="Masukkan kecamatan"
          />
          <InputError class="mt-2" :message="form.errors.kecamatan" />
        </div>

        <!-- Kelurahan Field -->
        <div class="grid gap-2">
          <Label for="kelurahan">Kelurahan:</Label>
          <Input
            id="kelurahan"
            type="text"
            class="mt-1 block w-full"
            v-model="form.kelurahan"
            placeholder="Masukkan kelurahan"
          />
          <InputError class="mt-2" :message="form.errors.kelurahan" />
        </div>

        <!-- RT Field -->
        <div class="grid gap-2">
          <Label for="RT">RT:</Label>
          <Input
            id="RT"
            type="text"
            class="mt-1 block w-full"
            v-model="form.RT"
            placeholder="Masukkan RT"
          />
          <InputError class="mt-2" :message="form.errors.RT" />
        </div>

        <!-- RW Field -->
        <div class="grid gap-2">
          <Label for="RW">RW:</Label>
          <Input
            id="RW"
            type="text"
            class="mt-1 block w-full"
            v-model="form.RW"
            placeholder="Masukkan RW"
          />
          <InputError class="mt-2" :message="form.errors.RW" />
        </div>

        <!-- Tanggal Lahir (TTL) Field -->
        <div class="grid gap-2">
          <Label for="TTL">Tanggal Lahir:</Label>
          <Input
            id="TTL"
            type="date"
            class="mt-1 block w-full"
            v-model="form.TTL"
          />
          <InputError class="mt-2" :message="form.errors.TTL" />
        </div>

        <!-- Jenis Kelamin Field -->
        <div class="grid gap-2">
          <Label for="jenis_kelamin">Jenis Kelamin:</Label>
          <select
            id="jenis_kelamin"
            v-model="form.jenis_kelamin"
            class="mt-1 block w-full border rounded-md p-2"
          >
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
          <InputError class="mt-2" :message="form.errors.jenis_kelamin" />
        </div>

        <!-- No Telepon Field -->
        <div class="grid gap-2">
          <Label for="no_telepon">No Telepon:</Label>
          <Input
            id="no_telepon"
            type="text"
            class="mt-1 block w-full"
            v-model="form.no_telepon"
            placeholder="Masukkan nomor telepon"
          />
          <InputError class="mt-2" :message="form.errors.no_telepon" />
        </div>

        <!-- Alamat (Jalan) Field -->
        <div class="grid gap-2">
          <Label for="jalan">Alamat:</Label>
          <Input
            id="jalan"
            type="text"
            class="mt-1 block w-full"
            v-model="form.jalan"
            placeholder="Masukkan alamat lengkap"
          />
          <InputError class="mt-2" :message="form.errors.jalan" />
        </div>

        <!-- NIK TPK Field -->
        <div class="grid gap-2">
          <Label for="nik_tpk">NIK TPK:</Label>
          <Input
            id="nik_tpk"
            type="text"
            class="mt-1 block w-full"
            v-model="form.nik_tpk"
            placeholder="Masukkan NIK TPK"
          />
          <InputError class="mt-2" :message="form.errors.nik_tpk" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
          <Button type="submit">Save</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
