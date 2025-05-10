<script setup lang="ts">
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import { ArrowRightIcon, ArrowLeftIcon } from '@heroicons/vue/24/outline';

import 'swiper/css/bundle';

// Daftar gambar slider
const images: string[] = [
  '/storage/1.svg',
  '/storage/2.svg',
  '/storage/3.svg',
  '/storage/4.svg',
];
</script>

<template>
  <div class="w-full mx-auto rounded-2xl overflow-hidden shadow-lg relative">
    <Swiper
      :modules="[Navigation, Pagination, Autoplay]"
      :slides-per-view="1"
      :space-between="20"
      :loop="true"
      :autoplay="{ delay: 4000, disableOnInteraction: false }"
      :navigation="{
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
      }"
      :pagination="{ clickable: true }"
      class="rounded-2xl"
    >
      <!-- Gambar Slide -->
      <SwiperSlide v-for="(img, index) in images" :key="index">
        <img
          :src="img"
          alt="Slide Image"
          class="w-full h-[515px] object-cover transition-all duration-700"
          loading="lazy"
        />
      </SwiperSlide>

      <!-- Tombol Navigasi Kustom -->
      <div
        class="swiper-button-prev-custom absolute top-1/2 left-4 -translate-y-1/2 z-10 bg-white/60 hover:bg-white p-2 rounded-full cursor-pointer shadow-md transition-transform transform hover:scale-110 duration-300"
      >
        <ArrowLeftIcon class="h-4 w-4 text-gray-800" />
      </div>
      <div
        class="swiper-button-next-custom absolute top-1/2 right-4 -translate-y-1/2 z-10 bg-white/60 hover:bg-white p-2 rounded-full cursor-pointer shadow-md transition-transform transform hover:scale-110 duration-300"
      >
        <ArrowRightIcon class="h-4 w-4 text-gray-800" />
      </div>
    </Swiper>
  </div>
</template>

<style scoped>
.swiper-pagination-bullet {
  background: white;
  opacity: 0.7;
}
.swiper-pagination-bullet-active {
  background: #2563eb; /* blue-600 */
  opacity: 1;
}
</style>
