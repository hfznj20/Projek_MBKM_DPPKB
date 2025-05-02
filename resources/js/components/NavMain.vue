<script setup lang="ts">
import { computed } from 'vue'; // 🔥 Import computed
import { SidebarGroup, SidebarGroupLabel, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps<{
    items: NavItem[];
}>();

const page = usePage<SharedData>();

const filteredItems = computed(() => {
  const role = page.props.auth.user.role;
  return props.items.filter((item: NavItem) => {
    return !item.guard || item.guard.includes(role);
  });
});
</script>

<template>
  <SidebarGroup class="px-2 py-0">
    <SidebarGroupLabel>Menu</SidebarGroupLabel>
    <SidebarMenu>
      <SidebarMenuItem v-for="item in filteredItems" :key="item.title">
        <SidebarMenuButton 
          as-child 
          :is-active="item.href === page.url"
          :tooltip="item.title"
        >
          <Link :href="item.href">
            <component :is="item.icon" />
            <span>{{ item.title }}</span>
          </Link>
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarGroup>
</template>
