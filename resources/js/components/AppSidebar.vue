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
    title: 'Pandu Genre',
    href: '/pandu-genre',
    icon: Hand,
    guard: ['admin']
  },
  {
    title: 'Data Penduduk',
    href: '/penduduk',
    icon: Users,
    guard: undefined
  },
  {
    title: 'Stunting',
    href: '/stunting-tpk',
    icon: ActivitySquare,
    guard: undefined
  },
  {
    title: 'Baduta',
    href: '/baduta',
    icon: Baby,
    guard: undefined
  },
  {
    title: 'Bumil',
    href: '/bumil',
    icon: HeartPulse,
    guard: undefined
  },
  {
    title: 'Pasca Persalinan',
    href: '/pasper',
    icon: Baby,
    guard: undefined,
  },
  {
    title: 'Catin',
    href: '/catin',
    icon: UserRound,
    guard: undefined
  },
  {
    title: 'Manajemen User',
    href: '/manajemen',
    icon: Settings,
    guard: ['admin']
  },
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
