<template>
<Html>
<Head>
<Title>最新のカリキュラム一覧</Title>
</Head>
</Html>


<section>
 
<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
  <span class="sr-only">Open sidebar</span>
  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
  <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
  </svg>
</button>

<aside id="sidebar-multi-level-sidebar" class="fixed top-32 left-0 z-40 w-96 h-screen transition-transform -translate-x-full sm:translate-x-0 shadow-lg rounded-lg" aria-label="Sidebar">
  <div class="h-full px-4 py-5 overflow-y-auto bg-white dark:bg-gray-900">
     <ul class="space-y-3" v-if="category_data?.length > 0">
        <li>
           <a href="#" class="flex items-center mb-5 p-3 text-4xl text-gray-800 rounded-md dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 group">
            <span class="inline-flex items-center justify-center h-14 w-14 text-xl"><IconFolderCog/></span>
              <h2 class="text-lg font-semibold text-gray-900 dark:text-white">カテゴリ</h2>
           </a>
           <ul class="flex flex-col pl-10">
            <li class="mb-5" v-for="(item, i) in category_data" :key="i">
              <span class="text-3xl text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white" @click="category_search(item.category_name)">{{ item.category_name }}</span>
              <ul class="flex flex-col pl-10">
                <li class="mt-3  transform hover:translate-x-2 transition-transform ease-in duration-200 text-2xl text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white" v-for="(curriculum_item, i) in item['curriculums']" :key="i">
                  <NuxtLink :to="`/user/curriculums/${curriculum_item.curriculum_slug}`"><span>{{ curriculum_item.curriculum_name }}</span></NuxtLink>
                  
                </li>
                
              </ul>
            </li>
            
          </ul>
        </li>
        
     </ul>
  </div>
</aside>

<div class="p-4 sm:ml-96 mt-32">
  <div class="grid lg:grid-cols-2 grid-cols-1 gap-4">
    <div class="flex justify-start gap-4 w-full items-baseline text-xl">
      <h1 class="text-2xl sm:text-5xl leading-5 sec-title my-12">カリキュラム管理</h1>
      <h3>全て</h3>
      <h3>受講中</h3>
      <h3>受講済み</h3>
    </div>
    
    <div class="mb-3">
      <div class="relative mt-1 lg:mt-14 flex w-full md:w-3/4 flex-wrap items-stretch">
        <input
          type="search"
          v-model="curriculum_name"
          class="relative no-underline text-xs w-1/2 md:w-9/12 m-0 block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white px-4 py-2 text-base font-normal leading-normal text-gray-700 outline-none transition duration-200 ease-in-out focus:border-blue-500 focus:shadow-outline"
          placeholder="カリキュラム検索"
          aria-label="Search"
          aria-describedby="button-addon2" />
    
        <!--Search button-->
        <button
          class="ml-3 inline-flex items-center justify-center rounded-md bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          type="button"
          id="button-addon2"
          @click.prevent="search">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="h-5 w-5">
            <path
              fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>
  
  </div>
  <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

    <ul class="grid lg:grid-cols-4 grid-cols-2 gap-4 mb-4" v-if="curriculum_data?.length > 0">
        <li v-for="(item, i) in curriculum_data" :key="i" class="flex items-center justify-center rounded bg-gray-50 dark:bg-gray-800">
           <p class="text-2xl text-gray-400 dark:text-gray-500">
            <CardCurriculumComponent
            mode="/user"
            :curriculum_slug="item.curriculum_slug"
            :curriculum_name="item.curriculum_name"
            :category_name="item.categories['category_name']"
            :curriculum_image="item.curriculum_image"
            :image_path="image_path"
            :no_image_path="no_image_path"
            />
           </p>
          </li>
        
      </ul>
  </div>
</div>


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
import type { SelectOptionItems,  CategoryData, CurriculumDirPath, CurriculumData, PaginatedResponse, DataType } from '@/types/index';
import { CurriculumType } from '@/types/const';
import { useToString } from '@vueuse/core';
import store from "@/store";
import { IconFolderCog } from '@tabler/icons-vue';

let fd: FormData;
const category_object = ref<PaginatedResponse<DataType> | null | undefined>();
const category_data = ref<CategoryData | null>();
const category_all = ref<CategoryData | null>();
const curriculum_object = ref<PaginatedResponse<DataType>| null | undefined>();
const curriculum_data = ref<CurriculumData| null>();
const curriculumTypeSelect = ref(null);
const curriculumTypeOptions = ref(<SelectOptionItems>[]);
const curriculum_name = ref('');
const category_name = ref('');
const curriculum_dir_path = ref<CurriculumDirPath>();
const image_path = ref('');
const no_image_path = ref('');
const parent_category_data = ref<SelectOptionItems | null>();


const { getAllCurriculumData, getCurriculumDirectoryPath } = curriculum();
const { userInfo, initUser } = useAuth();

const {
    getActiveCategory,
  getAllCategoryData,
  getParentCategory,
  destroyCategory,
  recoverCategory,
  setCategoryName,
} = category();

const erase = () =>
{

    eraseForm();
    
}

const category_search = (category_name: string) =>
{

    fd = new FormData;
    fd.append('status', 'A');
    fd.append('authority_ranks', userInfo.value['user_rank']);
    fd.append('created_at', useToString(userInfo.value['created_at']).value.replace('T', ' '));
    fd.append('order_item', 'created_at');
    fd.append('order_by', 'DESC');
 
    if (category_name !== '')
    {

        fd.append('category_name', category_name);

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

const search = () =>
{

    fd = new FormData;
    fd.append('status', 'A');
    fd.append('authority_ranks', userInfo.value['user_rank']);
    fd.append('created_at', useToString(userInfo.value['created_at']).value.replace('T', ' '));
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

    curriculum_object.value = await getAllCurriculumData('user', page, fd);
    curriculum_data.value = curriculum_object.value['data'];
    window.scroll({ top: 0, behavior: 'smooth'});

}

const init = async () =>
{

    await initUser();

    curriculumTypeOptions.value = arrangeAsSelectOptions(CurriculumType);

    fd = new FormData;
    fd.append('status', 'A');
    fd.append('authority_ranks', userInfo.value['user_rank']);
    fd.append('created_at', useToString(userInfo.value['created_at']).value.replace('T', ' '));
    fd.append('order_item', 'created_at');
    fd.append('order_by', 'DESC');

    [curriculum_object.value, category_all.value,category_data.value, curriculum_dir_path.value] = await Promise.all([
        getAllCurriculumData('user', 1, fd),
        getActiveCategory(),
        getAllCategoryData(),
        getCurriculumDirectoryPath()
    ]);

    curriculum_data.value = curriculum_object.value['data'];
    category_data.value = category_data.value['data']
    // category_data1.value = category_data.value
    image_path.value =curriculum_dir_path.value.image_path;
    no_image_path.value = curriculum_dir_path.value.no_image_path;

    console.log(curriculum_data.value,"test", category_data.value, category_all.value)
    
  // [category_object.value, parent_category_data.value] = await Promise.all([
  //   getAllCategoryData(1),
  //   getParentCategory(),
  // ]);
  
  // category_data.value = category_object.value["data"];
  // console.log("ttest",category_data)

}
init();
const { userLogout } = useAuth();

const logout = async () =>
{

	userLogout();
}
definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>