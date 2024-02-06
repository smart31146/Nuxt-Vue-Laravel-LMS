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
    
    <header class="header">
        <NuxtLink to="/" class="header-logo">
            <img src="/images/logo.png" alt="LMSシステムのロゴ">
        </NuxtLink>
      </header>
    <main class="">
    <slot />
    </main>
    
    <!-- <nav class="u-margin-bottom--1_5rem">
    <ul class="u-display--flex u-flex__align_items--center u-flex__justify_content--center u-flex__gap--1rem">
    <li><NuxtLink to="/misc/term" class="u-text-decoration--underline">利用規約</NuxtLink></li>
    <li><NuxtLink to="/misc/privacy-policy" class="u-text-decoration--underline">個人情報保護方針</NuxtLink></li>
    <li><NuxtLink to="/contact/" class="u-text-decoration--underline">お問い合わせ</NuxtLink></li>
    </ul>
    </nav> -->
    
    <footer class="footer">
        <p class="copyRight">&copy;2023<a class="border" href="https://skyskysky.jp/">Sky Inc.</a></p>
      </footer>
    </template>
    