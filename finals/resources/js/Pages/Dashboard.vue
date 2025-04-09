<template>
  <AppLayout>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

            <div v-if="$page.props.auth.user.isAdmin" class="mb-8">
              <h2 class="text-2xl font-semibold mb-4">Admin Panel</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Link
                  :href="route('services.index')"
                  class="p-4 bg-indigo-100 rounded-lg hover:bg-indigo-200"
                >
                  <h3 class="text-lg font-semibold text-indigo-800">Manage Services</h3>
                  <p class="text-indigo-600">Add, edit, or remove services</p>
                </Link>
                <Link
                  :href="route('bookings.index')"
                  class="p-4 bg-indigo-100 rounded-lg hover:bg-indigo-200"
                >
                  <h3 class="text-lg font-semibold text-indigo-800">Manage Bookings</h3>
                  <p class="text-indigo-600">View and manage all bookings</p>
                </Link>
              </div>
            </div>

            <div>
              <h2 class="text-2xl font-semibold mb-4">Your Bookings</h2>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Service
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="booking in bookings" :key="booking.id">
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ booking.service.name }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ new Date(booking.booking_date).toLocaleString() }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span
                          :class="{
                            'bg-yellow-100 text-yellow-800': booking.status === 'pending',
                            'bg-green-100 text-green-800': booking.status === 'confirmed',
                            'bg-red-100 text-red-800': booking.status === 'cancelled',
                            'bg-blue-100 text-blue-800': booking.status === 'completed',
                          }"
                          class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                        >
                          {{ booking.status }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button
                          v-if="booking.status === 'pending'"
                          @click="cancelBooking(booking)"
                          class="text-red-600 hover:text-red-900"
                        >
                          Cancel
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
  bookings: {
    type: Array,
    required: true,
  },
});

const cancelBooking = (booking) => {
  // Implement cancellation logic here
  console.log('Cancelling booking:', booking);
};
</script> 