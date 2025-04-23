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
  },
  {
    title: 'Data Penduduk',
    href: '/population_data',
    icon: Users,
  },
  {
    title: 'Stunting',
    href: '/stunting',
    icon: ActivitySquare,
  },
  {
    title: 'Pandu Genre',
    href: '/pandu-genre',
    icon: Hand,
  },
  {
    title: 'BADUTA',
    href: '/baduta',
    icon: Baby,
  },
  {
    title: 'BUMIL',
    href: '/bumil',
    icon: HeartPulse,
  },
  {
    title: 'CATIN',
    href: '/catin',
    icon: UserRound,
  },
  {
    title: 'Pasca Persalinan',
    href: '/pasca-persalinan',
    icon: HeartPulse,
  },
  {
    title: 'Kinerja TPK',
    href: '/kinerja-tpk',
    icon: ClipboardList,
  },
  {
    title: 'Manajemen User',
    href: '/manajemen-user',
    icon: Settings,
  },
];


const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
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
