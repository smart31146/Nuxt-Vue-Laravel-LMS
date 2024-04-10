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
		<meta name="csrf-token" content="{{ csrf_token() }}">
	</Head>
		</Html>

		<header class="header">
			<NuxtLink to="/service-admin/dashboard" class="header-logo">
				<img src="/images/logo.png" alt="LMSシステムのロゴ">
			</NuxtLink>
			<button class="header-menu" :class="{ 'is_click': isMenuOpen }" @click.prevent="setStateIsMenuOpen" >
			  <span></span>
			  <span></span>
			  <span></span>
			</button>
		  </header>

<main class="">
<slot />
</main>

<footer class="footer">
    <p class="copyRight">&copy;2023<a class="border" href="https://skyskysky.jp/">Sky Inc.</a></p>
  </footer>
</template>

<script setup lang="ts">

const isMenuOpen = ref(false);
const { adminLogout } = useAuth();

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

import store from '../store';
import { ref } from 'vue';

const stateIsMenuOpen = ref(store.state.stateIsMenuOpen);

const setStateIsMenuOpen = () => {
	isMenuOpen.value = !isMenuOpen.value;
  store.state.stateIsMenuOpen = isMenuOpen.value;
  
};
const logout = async () => {
  adminLogout();
};
</script>