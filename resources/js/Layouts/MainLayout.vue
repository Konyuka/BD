<script setup>
import { ref, computed, watch } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

defineProps({
    title: String,
});
const page = usePage();


const showingNavigationDropdown = ref(false);
const logout = () => {
    router.post(route('logout'));
};
const currentYear = computed(() => {
    const currentDate = new Date();
    return currentDate.getFullYear();
})
const currentMenu = computed(() => {
    return window.location.pathname
})
const message = computed(() => {
    return page.props.message;
})
const launchToaster = ref(false)
watch(message, (newX) => {
    if (newX) {
        launchToaster.value = true
        setTimeout(() => {
            launchToaster.value = false
        }, 3000);
    }
})

</script>

<template>
    <Head title="Dashboard" />

    <Transition enter-from-class="opacity-0 scale-125" enter-to-class="opacity-100 scale-100"
        enter-active-class="transition duration-300" leave-active-class="transition duration-200"
        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-125">
        <div v-if="launchToaster" aria-live="assertive"
            class="z-[1000] pointer-events-none fixed inset-0 flex items-end px-4 py-6 sm:items-start sm:p-6">
            <div class="flex w-full flex-col items-center space-y-4 sm:items-end">

                <div
                    class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-black shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-white">{{ message }}</p>
                            </div>
                            <div class="ml-4 flex flex-shrink-0">
                                <button @click="launchToaster = false" type="button"
                                    class="inline-flex rounded-md bg-black text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-5 w-5 text-primary" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path
                                            d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>

    <div class="min-h-full">
        <header class="bg-primary pb-24">
            <div class="mx-auto max-w-[95vw] px-4 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-center py-5 lg:justify-between">
                    <!-- Logo -->
                    <div class="absolute left-0 flex-shrink-0 lg:static">
                        <a href="#">
                            <span class="sr-only">Your Company</span>
                            <img class="h-20 w-auto" src="/img/logo.png" alt="Your Company">
                        </a>
                    </div>

                    <!-- Right section on desktop -->
                    <div class="hidden lg:ml-4 lg:flex lg:items-center lg:pr-0.5">


                        <!-- Profile dropdown -->
                        <div class="relative ml-4 flex-shrink-0">
                            <div>
                                <button @click="showingNavigationDropdown = !showingNavigationDropdown" type="button"
                                    class="group relative flex rounded-full bg-white text-sm ring-2 ring-white ring-opacity-20 focus:outline-none focus:ring-opacity-100"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <i
                                        class="group-hover:scale-75 duration-700 ease-in-out group-hover:text-secondary fas fa-user text-xl text-primary h-8 w-8"></i>
                                </button>
                            </div>


                            <Transition enter-from-class="opacity-0 scale-125" enter-to-class="opacity-100 scale-100"
                                enter-active-class="transition duration-300" leave-active-class="transition duration-200"
                                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-125">
                                <div v-if="showingNavigationDropdown"
                                    class="absolute -right-2 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                    tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <Link :href="route('profile.show')"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:font-bold duration-500 ease-in-out"
                                        role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</Link>

                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <button @click="logout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:font-bold duration-500 ease-in-out"
                                        role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</button>
                                </div>
                            </Transition>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="min-w-0 flex-1 px-12 lg:hidden">
                        <div class="mx-auto w-full max-w-xs">
                            <label for="desktop-search" class="sr-only">Search</label>
                            <div class="relative text-white focus-within:text-gray-600">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="desktop-search"
                                    class="block w-full rounded-md border-0 bg-white/20 py-1.5 pl-10 pr-3 text-white placeholder:text-white focus:bg-white focus:text-gray-900 focus:ring-0 focus:placeholder:text-gray-500 sm:text-sm sm:leading-6"
                                    placeholder="Search" type="search" name="search">
                            </div>
                        </div>
                    </div>

                    <!-- Menu button -->
                    <div class="absolute right-0 flex-shrink-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button"
                            class="relative inline-flex items-center justify-center rounded-md bg-transparent p-2 text-indigo-200 hover:bg-white hover:bg-opacity-10 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                            aria-expanded="false">
                            <span class="absolute -inset-0.5"></span>
                            <span class="sr-only">Open main menu</span>
                            <!-- Menu open: "hidden", Menu closed: "block" -->
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                            <!-- Menu open: "block", Menu closed: "hidden" -->
                            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="hidden border-t border-white border-opacity-20 py-5 lg:block">
                    <div class="grid grid-cols-4 items-center gap-8">
                        <div class="col-span-3">
                            <nav class="flex space-x-4 relative">
                                <!-- Current: "text-white", Default: "text-indigo-100" -->
                                <Link :href="route('dashboard')"
                                    :class="[currentMenu == '/dashboard' ? 'bg-white text-black' : 'bg-opacity-0 bg-white']"
                                    class="rounded-md  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                Tender Listing
                                </Link>

                                <Link :href="route('dashboard')"
                                    :class="[currentMenu == '/saved' ? 'bg-secondary' : 'bg-opacity-0']"
                                    class="text-white rounded-md bg-white  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                PPIP Tenders
                                </Link>

                                <Link :href="route('dashboard')"
                                    :class="[currentMenu == '/saved' ? 'bg-secondary' : 'bg-opacity-0']"
                                    class="text-white rounded-md bg-white  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                Tender Prequalifications
                                </Link>

                                <Link :href="route('dashboard')"
                                    :class="[currentMenu == '/saved' ? 'bg-secondary' : 'bg-opacity-0']"
                                    class="text-white rounded-md bg-white  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                Tender Notifications
                                </Link>

                                <Link :href="route('dashboard')"
                                    :class="[currentMenu == '/saved' ? 'bg-secondary' : 'bg-opacity-0']"
                                    class="text-white rounded-md bg-white  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                Saved Tenders
                                </Link>

                                <Link :href="route('get.tenders')"
                                    class="absolute bg-opacity-0 right-0 text-white rounded-md bg-white  px-5 py-2 text-lg font-medium hover:bg-opacity-10 hover:scale-90 duration-700 ease-in-out"
                                    aria-current="page">
                                <i class="fa-solid fa-cloud-arrow-down text-3xl"></i>
                                </Link>

                            </nav>
                        </div>
                        <div>
                            <div class="mx-auto w-full max-w-md">
                                <label for="mobile-search" class="sr-only">Search</label>
                                <div class="relative text-white focus-within:text-gray-600">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="mobile-search"
                                        class="block w-full rounded-md border-0 bg-white/20 py-1.5 pl-10 pr-3 text-white placeholder:text-white focus:bg-white focus:text-gray-900 focus:ring-0 focus:placeholder:text-gray-500 sm:text-sm sm:leading-6"
                                        placeholder="Search" type="search" name="search">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Mobile menu, show/hide based on mobile menu state. -->
            <div class="lg:hidden">

                <div class="fixed inset-0 z-20 bg-black bg-opacity-25" aria-hidden="true"></div>

                <div class="absolute inset-x-0 top-0 z-30 mx-auto w-full max-w-3xl origin-top transform p-2 transition">
                    <div class="divide-y divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="pb-2 pt-3">
                            <div class="flex items-center justify-between px-4">
                                <div>
                                    <img class="h-8 w-auto"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                        alt="Your Company">
                                </div>
                                <div class="-mr-2">
                                    <button type="button"
                                        class="relative inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="absolute -inset-0.5"></span>
                                        <span class="sr-only">Close menu</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Home</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Profile</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Resources</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Company
                                    Directory</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Openings</a>
                            </div>
                        </div>
                        <div class="pb-2 pt-4">
                            <div class="flex items-center px-5">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt="">
                                </div>
                                <div class="ml-3 min-w-0 flex-1">
                                    <div class="truncate text-base font-medium text-gray-800">Tom Cook</div>
                                    <div class="truncate text-sm font-medium text-gray-500">tom@example.com</div>
                                </div>
                                <button type="button"
                                    class="relative ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View notifications</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-3 space-y-1 px-2">
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Your
                                    Profile</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Settings</a>
                                <a href="#"
                                    class="block rounded-md px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-800">Sign
                                    out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="-mt-24 pb-8">
            <div class="mx-auto max-w-[95vw] px-4 sm:px-6 lg:px-8">
                <h1 class="sr-only">Page title</h1>
                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-4 lg:gap-8">

                    <!-- Left column -->
                    <div class="grid grid-cols-1 gap-4 lg:col-span-3">
                        <section aria-labelledby="section-1-title">
                            <h2 class="sr-only" id="section-1-title">Section title</h2>
                            <div class="overflow-hidden rounded-lg bg-white shadow min-h-[65vh]">
                                <div class="p-6">
                                    
                                    <slot />

                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Right column -->
                    <div class="grid grid-cols-1 gap-4">
                        <section aria-labelledby="section-2-title">
                            <h2 class="sr-only" id="section-2-title">Section title</h2>
                            <div class="overflow-hidden rounded-lg bg-white shadow min-h-[65vh]">
                                <div class="p-6">
                                    <!-- Your content -->


                                    
                                </div>
                            </div>
                        </section>
                    </div>


                </div>
            </div>
        </main>

        <footer>
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="border-t border-gray-200 py-8 text-center text-sm text-secondary sm:text-center"><span
                        class="block sm:inline">&copy; {{ currentYear }} Acentria Group.</span> <span
                        class="block sm:inline">All
                        rights reserved.</span></div>
            </div>
        </footer>


    </div>
</template>
