<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import MapView from '@/components/MapView.vue';
import BarChart from '@/components/ui/BarChart.vue';
import BarChart2 from '@/components/ui/BarChart2.vue';
import LineChart from '@/components/ui/LineChart.vue';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Beranda',
    href: '/dashboard',
  },
];
</script>
<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Peta -->
        <!-- Peta -->
    <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
      PETA PERSEBARAN
    </div>
    <div class="h-[400px] rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border">
      <MapView />
    </div>

    <!-- Diagram Batang 1 -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        DIAGRAM KATEGORI PER-KECAMATAN
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <BarChart />
      </div>
    </div>

    <!-- Diagram Batang 2 -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        JUMLAH BADUTA YANG TERKENA STUNTING & TIDAK TERKENA STUNTING DI KOTA PAREPARE
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <BarChart2/>
      </div>
    </div>

    <!-- Line Chart -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        GRAFIK PERKEMBANGAN BADUTA
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <LineChart />
      </div>
    </div>

    <!-- Placeholder Cards -->
    <div class="mt-4">
      <div class="mb-2 text-lg font-semibold bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded-t-xl">
        Informasi Tambahan
      </div>
      <div class="flex h-full flex-1 flex-col gap-4 rounded-b-xl p-4 border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-sidebar">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <PlaceholderPattern />
          </div>
          <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <PlaceholderPattern />
          </div>
          <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <PlaceholderPattern />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
