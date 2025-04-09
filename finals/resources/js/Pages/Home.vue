<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h1 class="text-3xl font-bold mb-8">Welcome to Hilot Sarap</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div v-for="service in services" :key="service.id" class="border rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-2">{{ service.name }}</h2>
                <p class="text-gray-600 mb-4">{{ service.description }}</p>
                <div class="flex justify-between items-center">
                  <span class="text-lg font-bold text-indigo-600">₱{{ service.price }}</span>
                  <span class="text-sm text-gray-500">{{ service.duration_minutes }} minutes</span>
                </div>
                <button
                  v-if="$page.props.auth.user"
                  @click="bookService(service)"
                  class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700"
                >
                  Book Now
                </button>
                <Link
                  v-else
                  :href="route('login')"
                  class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 text-center block"
                >
                  Login to Book
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  services: {
    type: Array,
    required: true,
  },
});

const bookService = (service) => {
  // Implement booking logic here
  console.log('Booking service:', service);
};
</script> 