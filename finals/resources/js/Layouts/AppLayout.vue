<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <Link :href="route('home')" class="text-2xl font-bold text-indigo-600">
                Hilot Sarap
              </Link>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
              <Link
                :href="route('home')"
                class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Home
              </Link>
              <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
              >
                Dashboard
              </Link>
            </div>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <div class="ml-3 relative">
              <div v-if="$page.props.auth.user">
                <span class="text-gray-700 mr-4">{{ $page.props.auth.user.name }}</span>
                <Link
                  :href="route('logout')"
                  method="post"
                  as="button"
                  class="text-gray-500 hover:text-gray-700"
                >
                  Logout
                </Link>
              </div>
              <div v-else>
                <Link
                  :href="route('login')"
                  class="text-gray-500 hover:text-gray-700"
                >
                  Login
                </Link>
                <Link
                  :href="route('register')"
                  class="ml-4 text-gray-500 hover:text-gray-700"
                >
                  Register
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script> 