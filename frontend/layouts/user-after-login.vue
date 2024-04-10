<template>
	<Html>
		<Head>
		<Link rel="preconnect" href="//cdnjs.cloudflare.com" />
		<Link rel="preconnect" href="//fonts.googleapis.com" />
		<Link rel="preconnect" href="//fonts.gstatic.com" crossorigin="anonymous" />
		<link rel="stylesheet preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<Link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;400&display=swap" />
		<Link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.0/css/all.css" />
		<Link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/destyle.css@1.0.15/destyle.css"/>
		<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
		
		<meta name="csrf-token" content="{{ csrf_token() }}">	
	</Head>
		</Html>

		<header>
			<Disclosure as="nav" class="w-full top-0 right-0 fixed z-30 bg-gradient-to-r from-blue-500 to-blue-700 shadow-lg" v-slot="{ open }">
				<div class="mx-auto px-2 py-8 sm:px-6 lg:px-8">
				  <div class="relative flex h-16 items-center justify-between">
					<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
					  <!-- Mobile menu button-->
					  <DisclosureButton class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
						<span class="absolute -inset-0.5" />
						<span class="sr-only">Open main menu</span>
						<Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
						<XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
					  </DisclosureButton>
					
					</div>
					<div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
					  <div class="flex flex-shrink-0 items-center">
						<NuxtLink href="/user/dashboard" ><img class="h-8 w-auto" src="/images/logo-white.png" alt="LMSシステムのロゴ" /> </NuxtLink>
					  </div>
					  
					  <div class="hidden sm:ml-12 sm:block">
						<div class="flex space-x-4">
						  <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-700 text-white' : ' text-white hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-3xl font-medium']" :aria-current="item.current ? 'page' : undefined" @click="setCurrent(item.name)">{{ item.name }}</a>
						</div>
					  </div>
					</div>
					<div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
			
					  <!-- Profile dropdown -->
					  <Menu as="div" class="relative ml-3">
						<div>
						  <MenuButton class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
							<span class="absolute -inset-1.5" />
							<span class="sr-only">Open user menu</span>
							<i class="fas fa-user-circle fa-4x text-gray-400"></i>	
						  </MenuButton>
						</div>
						<transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
						  <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
							<MenuItem v-slot="{ active }">
							  <NuxtLink href="/user/profile" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-2xl text-gray-700']">プロフィール</NuxtLink>
							</MenuItem>
							<MenuItem v-slot="{ active }">
								<NuxtLink href="/user/profile/edit" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-2xl text-gray-700']">設定</NuxtLink>
							</MenuItem>
							<MenuItem v-slot="{ active }">
							  <a @click="logout" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-2xl text-gray-700']">ログアウト</a>
							</MenuItem>
						  </MenuItems>
						</transition>
					  </Menu>
					</div>
				  </div>
				</div>
			
				<DisclosurePanel class="sm:hidden">
				  <div class="space-y-1 px-2 pb-3 pt-2">
					<DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'text-white' : 'text-white hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
				  </div>
				</DisclosurePanel>
			  </Disclosure>
		  </header>

<main class="">
<slot />
</main>

<footer class="footer">
    <p class="copyRight">&copy;2023<a class="border" href="https://skyskysky.jp/">Sky Inc.</a></p>
  </footer>
</template>

<script setup lang="ts">
	import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
    import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
	const route = useRoute()
      const navigation = [
      { name: 'ダッシュボード', href: '/user/dashboard', current: route.name=='user-dashboard' ? true : false },
      { name: '受講履歴', href: '/user/curriculums', current: route.name=='user-curriculums' ? true : false },
      { name: '終了証', href: '/user/certifications/', current: route.name=='user-certifications' ? true : false },
      { name: 'プロフィール', href: '/user/profile', current: route.name=='user-profile' ? true : false },
      ]

const isMenuOpen = ref(false);

import store from '../store';
import { ref } from 'vue';

const stateIsMenuOpen = ref(store.state.stateIsMenuOpen);

const setStateIsMenuOpen = () => {
	isMenuOpen.value = !isMenuOpen.value;
  store.state.stateIsMenuOpen = isMenuOpen.value;
  
};
const { userLogout } = useAuth();

const logout = async () =>
{

	userLogout();

}
</script>
