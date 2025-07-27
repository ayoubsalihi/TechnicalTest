<template>
  <div class="bg-white rounded-lg border border-gray-200 p-4 transition-all duration-300 hover:shadow-md">
    <div class="flex items-center">
      <div :class="color" class="p-3 rounded-lg">
        <i :class="icon" class="text-lg"></i>
      </div>
      <div class="ml-4">
        <h3 class="text-sm font-medium text-gray-500">{{ title }}</h3>
        <p class="text-2xl font-semibold mt-1">{{ value }}</p>
        <p v-if="change" class="text-xs mt-1" :class="change.startsWith('+') ? 'text-green-600' : 'text-red-600'">
          {{ change }} from last month
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  value: Number,
  icon: String,
  color: String,
  change: String
})
</script>