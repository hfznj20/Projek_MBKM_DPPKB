<script setup lang="ts">
import { cn } from '@/lib/utils'
import { useEventListener, useMediaQuery, useVModel } from '@vueuse/core'
import { TooltipProvider } from 'reka-ui'
import { computed, type HTMLAttributes, type Ref, ref } from 'vue'
import { provideSidebarContext, SIDEBAR_COOKIE_MAX_AGE, SIDEBAR_COOKIE_NAME, SIDEBAR_KEYBOARD_SHORTCUT, SIDEBAR_WIDTH, SIDEBAR_WIDTH_ICON } from './utils'

const props = withDefaults(defineProps<{
  defaultOpen?: boolean
  open?: boolean
  class?: HTMLAttributes['class']
}>(), {
  defaultOpen: true,
  open: undefined,
})

const emits = defineEmits<{
  'update:open': [open: boolean]
}>()

const isMobile = useMediaQuery('(max-width: 768px)')
const openMobile = ref(false)

const open = useVModel(props, 'open', emits, {
  defaultValue: props.defaultOpen ?? false,
  passive: (props.open === undefined) as false,
}) as Ref<boolean>

function setOpen(value: boolean) {
  open.value = value // emits('update:open', value)

  // This sets the cookie to keep the sidebar state.
  document.cookie = `${SIDEBAR_COOKIE_NAME}=${open.value}; path=/; max-age=${SIDEBAR_COOKIE_MAX_AGE}`
}

function setOpenMobile(value: boolean) {
  openMobile.value = value
}

// Helper to toggle the sidebar.
function toggleSidebar() {
  return isMobile.value ? setOpenMobile(!openMobile.value) : setOpen(!open.value)
}

useEventListener('keydown', (event: KeyboardEvent) => {
  if (event.key === SIDEBAR_KEYBOARD_SHORTCUT && (event.metaKey || event.ctrlKey)) {
    event.preventDefault()
    toggleSidebar()
  }
})

// We add a state so that we can do data-state="expanded" or "collapsed".
// This makes it easier to style the sidebar with Tailwind classes.
const state = computed(() => open.value ? 'expanded' : 'collapsed')

provideSidebarContext({
  state,
  open,
  setOpen,
  isMobile,
  openMobile,
  setOpenMobile,
  toggleSidebar,
})
</script>

<template>
  <TooltipProvider :delay-duration="0">
    <div
      data-slot="sidebar-wrapper"
      :style="{
        '--sidebar-width': SIDEBAR_WIDTH,
        '--sidebar-width-icon': SIDEBAR_WIDTH_ICON,
      }"
      :class="cn('group/sidebar-wrapper has-data-[variant=inset]:bg-sidebar flex flex-col min-h-svh w-full', props.class)"
      v-bind="$attrs"
    >
      <!-- TOP BAR -->
      <div class="sticky top-0 bg-[#37347E] h-12 w-full flex items-center px-4 text-white shadow shrink-0 z-50">
        <img src="/images/logo1.png" alt="Logo" class="h-full mr-3" />
        <div class="text-[6px] leading-tight" style="word-spacing: 3px;">
    <div>Dinas</div>
    <div>Pengendalian Penduduk</div>
    <div>dan Keluarga Berencana</div>
    <div>Kota Parepare</div>
  </div>
</div>

      <!-- MAIN LAYOUT -->
      <div class="flex flex-1 overflow-hidden">
        <!-- SIDEBAR -->
        <div
          v-if="open || isMobile"
          class="bg-[#C0C0C0] w-[var(--sidebar-width)] transition-all duration-300 overflow-auto"
>
          <!-- Slot untuk sidebar content -->
          <slot name="sidebar" />
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 overflow-auto p-4 bg-gray-100">
          <!-- Slot untuk main content -->
          <slot />
        </div>
      </div>
    </div>
  </TooltipProvider>
</template>
