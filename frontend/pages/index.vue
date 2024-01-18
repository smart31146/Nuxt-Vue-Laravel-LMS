<template>
    <Html>
    <Head>
    <Title>SKY LMSシステム</Title>
    
    </Head>
    </Html>
    
    <section class="u-padding-top--3rem u-padding-bottom--3rem" style="margin-top:80px">
    <h1 class="u-text-align--center">SKY LMSシステムとは</h1>
    <p class="u-text-align--center">株式会社スカイが運営する、教育管理システムです。</p>
    </section>
    
    <ul class="u-margin-left--auto u-margin-right--auto u-width--fit-content u-margin-bottom--1_5rem u-display--flex u-flex__gap--1rem u-flex-wrap">
    <li>カリキュラム名<br><input type="search" v-model="curriculum_name"></li>
    <li>カテゴリ名<br><input type="search" v-model="category_name"></li>
    <li><button class="p-button p-button--green" @click="search"><i class="fa fa-search"></i></button></li>
    <li><button class="p-button p-button--gray u-border__all--0_0625rem-black" @click="erase"><i class="fa fa-search"></i></button></li>
    </ul>
    
    <section class=" u-margin-bottom--3rem">
    <h2 class="u-text-align--center u-margin-bottom--1_5rem">最新のカリキュラム一覧</h2>
    <ul class="u-margin-bottom--3rem u-display--grid" v-if="curriculum_data?.length > 0">
    <li class="u-margin-bottom--1_5rem" v-for="(item, i) in curriculum_data" :key="i">
    <CardCurriculumComponent
    mode=""
    :curriculum_slug="item.curriculum_slug"
    :curriculum_name="item.curriculum_name"
    :curriculum_image="item.curriculum_image"
    :image_path="image_path"
    :no_image_path="no_image_path"
    />
    </li>
    </ul>
    
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
    </script>