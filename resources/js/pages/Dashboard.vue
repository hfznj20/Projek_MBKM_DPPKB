<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import BarChart from '@/components/ui/BarChart.vue';
import LineChart from '@/components/ui/LineChart.vue';
import BadutaMap from '@/components/BadutaMap.vue';
import BarChart2 from '@/components/ui/BarChart2.vue';
import { Users, ActivitySquare, ClipboardList } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Beranda',
    href: '/dashboard',
  },
];

const props = defineProps<{
  totalPerKategori: number;
  totalStunting: number;
  totalPerkembangan: number;
  persentasebaduta : number;
  persentasebumil : number;
  rankingStunting: Array<{ kecamatan: string, jumlah: number }>;
}>();

</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Peta -->
    <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
      PETA PERSEBARAN
    </div>
    <div class="h-[400px] rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border">
      <BadutaMap />
    </div>
    <!-- Peta -->
        <!-- Peta -->
        <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl mt-12">
  PETA PERSEBARAN
</div>
<div class="h-[400px] rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border mt-4 z-40"> <!-- Menambahkan mt-12 dan z-40 -->
  <MapView />
</div>

    <!-- Diagram Batang 1 -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        DISTRIBUSI DATA KATEGORI PER-KECAMATAN
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <BarChart />
      </div>
    </div>

    <!-- Diagram Batang 2 -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        JUMLAH BADUTA DAN BUMIL YANG TERKENA STUNTING & TIDAK TERKENA STUNTING DI KOTA PAREPARE
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <BarChart2 />
      </div>
    </div>

    <!-- Line Chart -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        GRAFIK PERKEMBANGAN STUNTING PADA BADUTA PER-BULAN
      </div>
      <div class="rounded-b-xl overflow-hidden border border-sidebar-border/70 dark:border-sidebar-border p-4 bg-white dark:bg-sidebar">
        <LineChart />
      </div>
    </div>

    <!-- DPPKB Dalam Angka -->
    <div class="mt-4">
      <div class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        DPPKB DALAM ANGKA
      </div>
      <div class="flex h-full flex-1 flex-col gap-4 rounded-b-xl p-4 border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-sidebar">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <!-- Total Penduduk -->
          <div class="relative aspect-video overflow-hidden rounded-xl bg-blue-500 shadow-md text-white p-4">
            <div class="text-4xl font-bold mt-4 mr-5">{{ props.totalPerKategori }}<span class="text-4xl align-top"> orang</span></div>
            <div class="text-sm font-medium mt-2 mr-5">Total Penduduk</div>
            <Users class="absolute right-2 top-4 w-25 h-25 opacity-20" />
          </div>

          <!-- Total Stunting -->
          <div class="relative aspect-video overflow-hidden rounded-xl bg-green-600 shadow-md text-white p-4">
            <div class="text-4xl font-bold mt-4 mr-5">{{ props.totalStunting }}<span class="text-4xl align-top"> orang</span></div>
            <div class="text-sm font-medium mt-2 mr-5">Total Stunting</div>
            <ActivitySquare class="absolute right-2 top-4 w-25 h-25 opacity-20" />
          </div>
          
          <!-- Perkembangan Baduta -->
          <div class="relative aspect-video overflow-hidden rounded-xl bg-orange-500 shadow-md text-white p-4">
            <div class="text-4xl font-bold mt-4">{{ props.totalPerkembangan }}<span class="text-4xl align-top">%</span></div>
            <div class="text-sm font-medium mt-2">Baduta Stunting yang Mendapatkan Terapi</div>
            <ClipboardList class="absolute right-2 top-4 w-25 h-25 opacity-20" />
          </div>

          <!-- Total Stunting -->
          <div class="relative aspect-video overflow-hidden rounded-xl bg-pink-600 shadow-md text-white p-4">
            <div class="text-4xl font-bold mt-4 mr-5">{{ props.persentasebaduta }}<span class="text-4xl align-top">%</span></div>
            <div class="text-sm font-medium mt-2 mr-5">Baduta yang Terkena Stunting</div>
            <ActivitySquare class="absolute right-2 top-4 w-25 h-25 opacity-20" />
          </div>

          <!-- Total Stunting -->
          <div class="relative aspect-video overflow-hidden rounded-xl bg-yellow-600 shadow-md text-white p-4">
            <div class="text-4xl font-bold mt-4 mr-5">{{ props.persentasebumil }}<span class="text-4xl align-top">%</span></div>
            <div class="text-sm font-medium mt-2 mr-5">Bumil yang Terkena Stunting</div>
            <ActivitySquare class="absolute right-2 top-4 w-25 h-25 opacity-20" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
