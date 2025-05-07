<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
  BookOpen,
  Folder,
  Home,
  Users,
  ActivitySquare,
  Baby,
  HeartPulse,
  Hand,
  UserRound,
  ClipboardList,
  Settings
} from 'lucide-vue-next';

import AppLogo from './AppLogo.vue';


const mainNavItems: NavItem[] = [
{
    title: 'Beranda',
    href: '/dashboard',
    icon: Home,
    guard: undefined
  },
  {
    title: 'Data Penduduk',
    href: '/population_data',
    icon: Users,
    guard: ['admin']
  },
  {
    title: 'Stunting',
    href: '/stunting',
    icon: ActivitySquare,
    guard: ['admin']
  },
  {
    title: 'Pandu Genre',
    href: '/pandu-genre',
    icon: Hand,
    guard: ['admin']
  },
  {
    title: 'Baduta',
    href: '/baduta',
    icon: Baby,
    guard: ['admin']
  },
  {
    title: 'Bumil',
    href: '/bumil',
    icon: HeartPulse,
    guard: ['admin']
  },
  {
    title: 'Catin',
    href: '/catin',
    icon: UserRound,
    guard: ['admin']
  },
  {
    title: 'Pasca Persalinan',
    href: '/pasca-persalinan',
    icon: HeartPulse,
    guard: ['admin']
  },
  {
    title: 'Kinerja TPK',
    href: '/kinerja-tpk',
    icon: ClipboardList,
    guard: ['admin']
  },
  {
    title: 'Manajemen User',
    href: '/manajemen',
    icon: Settings,
    guard: ['admin']
  },

  // ===== TPK Section =====
  {
    title: 'Data Penduduk',
    href: '/penduduk',
    icon: Users,
    guard: ['TPK']
  },
  {
    title: 'Stunting',
    href: '/stunting-tpk',
    icon: ActivitySquare,
    guard: ['TPK']
  },
  {
    title: 'Baduta',
    href: '/baduta',
    icon: Baby,
    guard: ['TPK']
  },
  {
    title: 'Bumil',
    href: '/bumil',
    icon: HeartPulse,
    guard: ['TPK']
  },
  {
    title: 'Pasca Persalinan',
    href: '/pasper',
    icon: Baby,
    guard: ['TPK'],
  },
  {
      title: 'Catin',
      href: '/catin',
      icon: UserRound,
      guard: ['TPK']
  }
  ];
const footerNavItems: NavItem[] = [
    {
      title: 'Github Repo',
      href: 'https://github.com/laravel/vue-starter-kit',
      icon: Folder,
      guard: undefined
    },
    {
      title: 'Documentation',
      href: 'https://laravel.com/docs/starter-kits',
      icon: BookOpen,
      guard: undefined
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
