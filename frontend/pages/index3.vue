<template>
    <Html>
    <Head>
    <Title>SKY LMSシステム</Title>
    
    </Head>
    </Html>
    
    <section class="mb-3 mt-24">
      <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
         <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
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
                 <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" />
               </div>
               <div class="hidden sm:ml-6 sm:block">
                 <div class="flex space-x-4">
                   <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                 </div>
               </div>
             </div>
             <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
               <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                 <span class="absolute -inset-1.5" />
                 <span class="sr-only">View notifications</span>
                 <BellIcon class="h-6 w-6" aria-hidden="true" />
               </button>
     
               <!-- Profile dropdown -->
               <Menu as="div" class="relative ml-3">
                 <div>
                   <MenuButton class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                     <span class="absolute -inset-1.5" />
                     <span class="sr-only">Open user menu</span>
                     <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                   </MenuButton>
                 </div>
                 <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                   <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                     <MenuItem v-slot="{ active }">
                       <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Your Profile</a>
                     </MenuItem>
                     <MenuItem v-slot="{ active }">
                       <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Settings</a>
                     </MenuItem>
                     <MenuItem v-slot="{ active }">
                       <a href="#" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">Sign out</a>
                     </MenuItem>
                   </MenuItems>
                 </transition>
               </Menu>
             </div>
           </div>
         </div>
     
         <DisclosurePanel class="sm:hidden">
           <div class="space-y-1 px-2 pb-3 pt-2">
             <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
           </div>
         </DisclosurePanel>
       </Disclosure>
    <PaginationComponent
    :data="curriculum_object"
    :limit="3"
    :keep-length="false"
    @pagination-change-page="pagingCurriculumData"
    />
    <p class="u-text-align--center u-margin-bottom--1_5rem" v-if="curriculum_data?.length === 0">現在、利用可能なカリキュラムはありません。</p>
    </section>
    </template>
    
    <script setup lang="ts">
    import type { SelectOptionItems, CurriculumDirPath, CurriculumData, PaginatedResponse, DataType } from '@/types/index';
    import { CurriculumType } from '@/types/const';
    
    let fd: FormData;
    const curriculum_object = ref<PaginatedResponse<DataType>| null | undefined>();
    const curriculum_data = ref<CurriculumData| null>();
    const category_data = ref<SelectOptionItems | null>();
    const curriculumTypeSelect = ref(null);
    const curriculumTypeOptions = ref(<SelectOptionItems>[]);
    const curriculum_name = ref('');
    const category_name = ref('');
    const curriculum_dir_path = ref<CurriculumDirPath>();
    const image_path = ref('');
    const no_image_path = ref('');
    
    const { getActiveCategory } = category();
    const { getAllCurriculumData, getCurriculumDirectoryPath } = curriculum();
// ---new function----
    import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
      import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'

      const navigation = [
      { name: 'Dashboard', href: '#', current: true },
      { name: 'Team', href: '#', current: false },
      { name: 'Projects', href: '#', current: false },
      { name: 'Calendar', href: '#', current: false },
      ]

    const erase = () =>
    {
    
        eraseForm();
    
    }
    
    const search = () =>
    {
    
        fd = new FormData;
        fd.append('status', 'A');
        fd.append('authority_ranks', '0');
        fd.append('order_item', 'created_at');
        fd.append('order_by', 'DESC');
    
        if (curriculum_name.value !== '')
        {
    
            fd.append('curriculum_name', curriculum_name.value);
    
        }
    
        if (category_name.value !== '')
        {
    
            fd.append('category_name', category_name.value);
    
        }
    
        if (curriculumTypeSelect.value !== null)
        {
    
            if (curriculumTypeSelect.value.getSelectedValue()['key'] !== undefined)
            {
    
                fd.append('curriculum_type', curriculumTypeSelect.value.getSelectedValue()['key']);
    
            }
    
        }
    
        pagingCurriculumData(1);
    
    }
    
    const pagingCurriculumData = async (page: number) =>
    {
    
        curriculum_object.value = await getAllCurriculumData('open', page, fd);
        curriculum_data.value = curriculum_object.value['data'];
        window.scroll({ top: 0, behavior: 'smooth'});
    
    }
    
    const init = async () =>
    {
    
        curriculumTypeOptions.value = arrangeAsSelectOptions(CurriculumType);
    
        fd = new FormData;
        fd.append('status', 'A');
        fd.append('authority_ranks', '0');
        fd.append('order_item', 'created_at');
        fd.append('order_by', 'DESC');
    
        [curriculum_object.value, category_data.value, curriculum_dir_path.value] = await Promise.all([
            getAllCurriculumData('open', 1, fd),
            getActiveCategory(),
            getCurriculumDirectoryPath()
        ]);
    
        if (curriculum_object.value)
        {
    
            curriculum_data.value = curriculum_object.value['data'];
    
        }
    
        image_path.value =curriculum_dir_path.value.image_path;
        no_image_path.value = curriculum_dir_path.value.no_image_path;
    
    }
    init();
    </script>