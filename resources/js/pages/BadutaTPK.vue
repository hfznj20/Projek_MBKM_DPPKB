<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue'; // pastikan path sudah betul

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Beranda', href: '/dashboard' },
    { title: 'Data Baduta TPK', href: '/baduta_tpk' },
];
</script>

<template>
    <Head title="Data Baduta TPK" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <h1 class="text-2xl font-semibold text-gray-800 mb-4">
                Data Baduta TPK
            </h1>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="i in 6"
                    :key="i"
                    class="relative aspect-video overflow-hidden rounded-xl border border-gray-300 dark:border-gray-700"
                >
                    <PlaceholderPattern />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
