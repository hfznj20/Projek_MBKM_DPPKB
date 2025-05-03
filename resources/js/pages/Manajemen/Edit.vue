<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { computed } from 'vue';

const props = defineProps<{
    manajemen: {
        NIK: string;
        nama: string;
        kecamatan: string;
        kelurahan: string;
        email: string;
        password: string;
    };
}>();

// Inisialisasi form dengan data yang diterima dari props
const form = useForm({
    NIK: props.manajemen.NIK,
    nama: props.manajemen.nama,
    kecamatan: props.manajemen.kecamatan,
    kelurahan: props.manajemen.kelurahan,
    email: props.manajemen.email, // Menambahkan email
    password: '', // Kosongkan untuk password baru
    password_confirmation: '', // Kosongkan untuk password baru
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen User', href: route('manajemen.index') },
    { title: 'Edit Data', href: '#' },
];

// Definisikan tipe untuk kecamatan dan kelurahan
type KecamatanID = 'A' | 'B' | 'C' | 'D';
interface KelurahanOption {
    id: string;
    name: string;
}

const kecamatanOptions: {id: KecamatanID, name: string}[] = [
  { id: 'A', name: 'Kecamatan A' },
  { id: 'B', name: 'Kecamatan B' },
  { id: 'C', name: 'Kecamatan C' },
  { id: 'D', name: 'Kecamatan D' },
];

const kelurahanOptions: Record<KecamatanID, KelurahanOption[]> = {
  A: [
    { id: '1', name: 'Kelurahan 1' },
    { id: '2', name: 'Kelurahan 2' },
    { id: '3', name: 'Kelurahan 3' },
  ],
  B: [
    { id: '6', name: 'Kelurahan 6' },
    { id: '7', name: 'Kelurahan 7' },
    { id: '9', name: 'Kelurahan 9' },
  ],
  C: [
    { id: '4', name: 'Kelurahan 4' },
    { id: '5', name: 'Kelurahan 5' },
    { id: '8', name: 'Kelurahan 8' },
  ],
  D: [
    { id: '10', name: 'Kelurahan 10' },
    { id: '11', name: 'Kelurahan 11' },
    { id: '12', name: 'Kelurahan 12' },
  ],
};

const filteredKelurahan = computed(() => {
  if (!form.kecamatan) return [];
  return kelurahanOptions[form.kecamatan as KecamatanID] || [];
});

const submit = () => {
    form.put(route('manajemen.update', form.NIK), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            console.log('Data berhasil diperbarui');
            window.location.href = route('manajemen.index');
        },
        onError: (errors) => {
            console.error('Update error:', errors);
            alert("Ada Kesalahan dalam Pengisian Akun!");
        }
    });
};

const confirmDelete = () => {
    if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
        form.delete(route('manajemen.destroy', form.NIK), {
            onSuccess: () => {
                window.location.href = route('manajemen.index');
            },
            onError: (errors) => {
                console.error('Delete error:', errors);
            }
        });
    }
};
</script>

<template>
    <Head title="Edit Data Manajemen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit Data Manajemen</h1>
                <Link
                    :href="route('manajemen.index')"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600"
                >
                    Kembali
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIK Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                            <input
                                v-model="form.NIK"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                                disabled
                            />
                            <InputError :message="form.errors.NIK" class="mt-1" />
                        </div>

                        <!-- Nama Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input
                                v-model="form.nama"
                                type="text"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <InputError :message="form.errors.nama" class="mt-1" />
                        </div>

                        <!-- Kecamatan Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                            <select
                                v-model="form.kecamatan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                @change="form.kelurahan = ''"
                            >
                                <option value="">Pilih Kecamatan</option>
                                <option v-for="kecamatan in kecamatanOptions" 
                                        :key="kecamatan.id" 
                                        :value="kecamatan.id">
                                    {{ kecamatan.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.kecamatan" class="mt-1" />
                        </div>

                        <!-- Kelurahan Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelurahan</label>
                            <select
                                v-model="form.kelurahan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :disabled="!form.kecamatan"
                            >
                                <option value="">Pilih Kelurahan</option>
                                <option v-for="kelurahan in filteredKelurahan" 
                                        :key="kelurahan.id" 
                                        :value="kelurahan.id">
                                    {{ kelurahan.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.kelurahan" class="mt-1" />
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="Masukkan email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <InputError :message="form.errors.email" class="mt-1" />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input
                                v-model="form.password"
                                type="password"
                                placeholder="Masukkan password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <InputError :message="form.errors.password" class="mt-1" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Konfirmasi password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                            <InputError :message="form.errors.password_confirmation" class="mt-1" />
                        </div>

                        <!-- Form Actions -->
                        <div class="md:col-span-2 flex justify-end gap-3 pt-4">
                            <Link
                                :href="route('manajemen.index')"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition"
                            >
                                Batal
                            </Link>

                            <Button
                                type="button"
                                variant="destructive"
                                @click="confirmDelete"
                            >
                                Hapus Data
                            </Button>

                            <Button
                                type="submit"
                                :disabled="form.processing"
                            >
                                <span v-if="form.processing">Menyimpan...</span>
                                <span v-else>Simpan Perubahan</span>
                            </Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
