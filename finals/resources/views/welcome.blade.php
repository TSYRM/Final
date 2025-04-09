<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hilot Sarap</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <h1 class="text-4xl font-bold text-indigo-600">Hilot Sarap</h1>
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold">Welcome to Hilot Sarap</div>
                            </div>

                            <div class="ml-4">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    Experience the authentic Filipino massage service. Book your appointment today for a relaxing experience!
                                </div>
                            </div>
                        </div>

                        <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                            <div class="flex items-center">
                                <div class="ml-4 text-lg leading-7 font-semibold">Our Services</div>
                            </div>

                            <div class="ml-4">
                                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                    <ul class="list-disc pl-5">
                                        <li>Traditional Filipino Massage</li>
                                        <li>Aromatherapy Massage</li>
                                        <li>Hot Stone Therapy</li>
                                        <li>Foot Reflexology</li>
                                        <li>Full Body Scrub</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4 sm:items-center">
                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Login</a>
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
