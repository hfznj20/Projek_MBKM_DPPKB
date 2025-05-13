<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { computed } from 'vue'; 

const form = useForm({
    NIK: '',
    nama: '',
    kecamatan: '' as 'A' | 'B' | 'C' | 'D' | '', 
    kelurahan: '',
    email:'',
    password:'',
    password_confirmation:''
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen', href: route('manajemen.index') },
    { title: 'Tambah Data', href: route('manajemen.create') },
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
    form.post(route('manajemen.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            console.log('Data berhasil disimpan');
            router.visit(route('manajemen.index'));
        },
        onError: (errors) => {
            console.error('Submission error:', errors);
            alert("Ada Kesalahan dalam Pengisian Akun!");
        }

    });
};
</script>

<template>
    <Head title="Tambah Data Manajemen User" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-4">
            <div class="flex justify-between items-center">
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
                        <!-- NIK Field -->
                        <div>
                            <Label class="mb-2 block">NIK</Label>
                            <Input
                                v-model="form.NIK"
                                type="text"
                                placeholder="Masukkan NIK (16 digit)"
                                maxlength="16"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.NIK" class="mt-1" />
                        </div>

                        <!-- Nama Field -->
                        <div>
                            <Label class="mb-2 block">Nama</Label>
                            <Input
                                v-model="form.nama"
                                type="text"
                                placeholder="Masukkan nama"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.nama" class="mt-1" />
                        </div>

                        <!-- Kecamatan Field -->
                        <div>
                            <Label class="mb-2 block">Kecamatan</Label>
                            <select
                                v-model="form.kecamatan"
                                class="w-full px-3 py-1 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
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
                            <Label class="mb-2 block">Kelurahan</Label>
                            <select
                                v-model="form.kelurahan"
                                class="w-full px-3 py-1 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
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
                            <Label class="mb-2 block">Email</Label>
                            <Input
                                v-model="form.email"
                                type="text"
                                placeholder="Masukkan email"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.email" class="mt-1" />
                        </div>

                        <!-- Password Field -->
                        <div>
                            <Label class="mb-2 block">Password</Label>
                            <Input
                                v-model="form.password"
                                type="password"
                                placeholder="Masukkan password"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.password" class="mt-1" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <Label class="mb-2 block">Confirm Password</Label>
                            <Input
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Konfirmasi password"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.password_confirmation" class="mt-1" />
                        </div>

                        <!-- Form Actions -->
                       <div class="md:col-span-2 flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">
                            <Link
                                :href="route('manajemen.index')"
                                class="w-full sm:w-auto text-center px-4 py-1 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors"
                            >
                                Batal
                            </Link>
                            <Button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full sm:w-auto bg-green-500 text-white px-6 py-1 rounded hover:bg-green-600 transition text-sm"
                            >
                                <span v-if="form.processing">Menyimpan...</span>
                                <span v-else>Simpan Data</span>
                            </Button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>