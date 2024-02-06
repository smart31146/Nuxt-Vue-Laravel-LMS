<template>
    <Html>
    <Head>
    <Title>SKY LMSシステム</Title>
    
    </Head>
    </Html>
    
    <section class="mb-3 mt-44">
    <h1 class="mb-4 text-5xl text-center">SKY LMSシステムとは</h1>
    <p class="text-3xl text-center">株式会社スカイが運営する、教育管理システムです。</p>
    </section>
    
    <div class="max-w-screen-xl w-full m-auto flex justify-end">
        
        <div class="mb-3 flex w-2/4">
          <div class="relative mt-10 gap-4 flex w-full flex-wrap items-stretch">
            <label>カリキュラム名</label>
            <input
              v-model="curriculum_name"
              type="search"
              class="relative no-underline text-xs w-2/12 m-0 -mr-0.5 block min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
              placeholder="カリキュラム検索"
              aria-label="Search"
              aria-describedby="button-addon1" />
            <label>カテゴリ名</label>
            <input
              v-model="category_name"
              type="search"
              class="relative no-underline text-xs w-2/12 m-0 -mr-0.5 block min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
              placeholder="カリキュラム検索"
              aria-label="Search"
              aria-describedby="button-addon1" />
        
            <!--Search button-->
            <button
              class="bg-blue-800 relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
              type="button"
              id="button-addon1"
              data-te-ripple-init
              data-te-ripple-color="light" @click.prevent="search">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="h-5 w-5">
                <path
                  fill-rule="evenodd"
                  d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
      
      </div>
    <section class="max-w-screen-xl w-full m-auto">
    <h2 class="text-center mb-2">最新のカリキュラム一覧</h2>
    <div class="table-area">
        <div class="table-inner">
            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4" v-if="curriculum_data?.length > 0">
                <li v-for="(item, i) in curriculum_data" :key="i">
                <CardCurriculumComponent
                mode="/user"
                :curriculum_slug="item.curriculum_slug"
                :curriculum_name="item.curriculum_name"
                :curriculum_image="item.curriculum_image"
                :image_path="image_path"
                :no_image_path="no_image_path"
                />
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
    definePageMeta({
    layout: 'user-before-login',
});
    </script>