<!-- EDIR -->
<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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

const form = useForm({
    NIK: props.manajemen.NIK,
    nama: props.manajemen.nama,
    kecamatan: props.manajemen.kecamatan,
    kelurahan: props.manajemen.kelurahan,
    email: props.manajemen.email,
    password: '',
    password_confirmation: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen', href: route('manajemen.index') },
    { title: 'Edit Data', href: '#' },
];

type KecamatanID = 'A' | 'B' | 'C' | 'D';
interface KelurahanOption {
    id: string;
    name: string;
}

const kecamatanOptions: { id: KecamatanID; name: string }[] = [
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
            router.visit(route('manajemen.index'));
        },
        onError: (errors) => {
            console.error('Update error:', errors);
            alert('Ada Kesalahan dalam Pengisian Akun!');
        }
    });
};

const confirmDelete = () => {
    if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
        form.delete(route('manajemen.destroy', form.NIK), {
            onSuccess: () => {
                router.visit(route('manajemen.index'));
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
        <div class="flex flex-col gap-6 p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit Data Manajemen</h1>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- NIK -->
                        <div>
                            <Label class="mb-2 block">NIK</Label>
                            <Input
                                v-model="form.NIK"
                                type="text"
                                disabled
                                class="bg-gray-100"
                            />
                            <InputError :message="form.errors.NIK" class="mt-1" />
                        </div>

                        <!-- Nama -->
                        <div>
                            <Label class="mb-2 block">Nama</Label>
                            <Input
                                v-model="form.nama"
                                type="text"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.nama" class="mt-1" />
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <Label class="mb-2 block">Kecamatan</Label>
                            <select
                                v-model="form.kecamatan"
                                class="w-full px-3 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                                @change="form.kelurahan = ''"
                            >
                                <option value="">Pilih Kecamatan</option>
                                <option v-for="kecamatan in kecamatanOptions" :key="kecamatan.id" :value="kecamatan.id">
                                    {{ kecamatan.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.kecamatan" class="mt-1" />
                        </div>

                        <!-- Kelurahan -->
                        <div>
                            <Label class="mb-2 block">Kelurahan</Label>
                            <select
                                v-model="form.kelurahan"
                                :disabled="!form.kecamatan"
                                class="w-full px-3 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            >
                                <option value="">Pilih Kelurahan</option>
                                <option v-for="kelurahan in filteredKelurahan" :key="kelurahan.id" :value="kelurahan.id">
                                    {{ kelurahan.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.kelurahan" class="mt-1" />
                        </div>

                        <!-- Email -->
                        <div>
                            <Label class="mb-2 block">Email</Label>
                            <Input
                                v-model="form.email"
                                type="email"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.email" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <Label class="mb-2 block">Password</Label>
                            <Input
                                v-model="form.password"
                                type="password"
                                placeholder="Kosongkan jika tidak ingin ubah"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.password" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <Label class="mb-2 block">Konfirmasi Password</Label>
                            <Input
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Ulangi password"
                                class="border border-orange-500 focus:ring-2 focus:ring-orange-500"
                            />
                            <InputError :message="form.errors.password_confirmation" class="mt-1" />
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-6">
                        <Link
                            :href="route('manajemen.index')"
                            class="w-full sm:w-auto text-center px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
                        >
                            Batal
                        </Link>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full sm:w-auto bg-green-500 hover:bg-green-600 transition"
                        >
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Perubahan</span>
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>