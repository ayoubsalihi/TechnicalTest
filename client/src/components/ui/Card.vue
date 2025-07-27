<template>
  <div class="bg-white rounded-lg shadow">
    <div v-if="$slots.header" class="px-6 py-4 border-b border-gray-200">
      <slot name="header" />
    </div>
    <div class="p-6">
      <slot />
    </div>
    <div v-if="$slots.footer" class="px-6 py-4 bg-gray-50 rounded-b-lg">
      <slot name="footer" />
    </div>
  </div>
</template>