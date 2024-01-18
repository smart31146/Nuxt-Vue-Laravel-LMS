<template>
<Html>
<Head>
<Title>受講履歴</Title>
</Head>
</Html>

<section>
<h1 class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem">受講履歴</h1>
<ul class="u-width__min--95vw-64rem u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-display--flex u-flex__gap--1rem u-flex-wrap">
<li>カリキュラム名<br><input type="search" v-model="curriculum_name"></li>
<li>カテゴリ名<br><input type="search" v-model="category_name"></li>
<li>必修/任意<br>
<SelectComponent
ref="requiredTypeSelect"
item_name="required_type"
defaultValue=""
:data="requiredTypeOptions"
style="width: 13rem;"
/>
</li>
<li>カリキュラム種別<br>
<SelectComponent
ref="curriculumTypeSelect"
item_name="curriculum_type"
defaultValue=""
:data="curriculumTypeOptions"
style="width: 17rem;"
/>
</li>
<li>状態<br>
<SelectComponent
ref="statusSelect"
item_name="status"
defaultValue=""
:data="statusOptions"
style="width: 13rem;"
/>
</li>
<li><button class="p-button p-button--green" @click="search"><i class="fa fa-search"></i></button></li>
<li><button class="p-button p-button--gray u-border__all--0_0625rem-black" @click="erase"><i class="fa fa-search"></i></button></li>
</ul>

<p class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content">受講可能な必修受講総数: {{ total_count }}、完了数: {{ total_completed }}、達成率: {{ completed_percent }}% </p>

<table class="u-margin-left--auto u-margin-right--auto u-margin-bottom--1_5rem u-width--fit-content u-table">
<thead>
<tr>
<th>カリキュラム名</th>
<th>カテゴリ名</th>
<th>カリキュラム種別</th>
<th>必修/任意</th>
<th>受講開始日時</th>
<th>受講終了日時</th>
<th>進捗状況</th>
<th>状態</th>
<th></th>
</tr>
</thead>
<tbody>
<tr v-for="(item, i) in taking_curriculum_data" :key="i">
<td><NuxtLink :to="`/user/curriculums/${item.curriculum_slug}`" class="u-text-decoration--underline">{{ item.curriculum_name }}</NuxtLink></td>
<td>{{ item.category_name }}</td>
<td>{{ CurriculumType.get(item.curriculum_type.toString()) }}</td>
<td>{{ RequiredType.get(item.is_required.toString()) }}</td>
<td>{{ dateTimeFormat(item.started_at).value }}</td>
<td>{{ item.completed_at ? dateTimeFormat(item.completed_at).value  : '' }}</td>
<td>{{ getPercentage(item.taking_curriculum_second, item.total_curriculum_second) }}%</td>
<td>{{ TakingCurriculumStatus.get(item.status) }}</td>
<td>
<ul class="u-display--flex u-flex__gap--0_5rem">
<li><NuxtLink :to="`/user/curriculums/${item.curriculum_slug}`"><i class="fa fa-circle-info"></i></NuxtLink></li>
</ul>
</td>
</tr>
</tbody>
</table>

<PaginationComponent
:data="taking_curriculum_object"
:limit="3"
:keep-length="false"
@pagination-change-page="pagingTakingCurriculumData"
/>

</section>
</template>

<script setup lang="ts">
import type { SelectOptionItems, CurriculumData, PaginatedResponse, DataType, TakingCurriculumData } from '@/types/index';
import { RequiredType, CurriculumType, TakingCurriculumStatus } from '@/types/const';

let fd: FormData;
const taking_curriculum_object = ref<PaginatedResponse<DataType>| null | undefined>();
const taking_curriculum_data = ref<TakingCurriculumData | null>();
const category_data = ref<SelectOptionItems | null>();
const statusSelect = ref(null);
const requiredTypeSelect = ref(null);
const curriculumTypeSelect = ref(null);
const statusOptions = ref(<SelectOptionItems>[]);
const curriculumTypeOptions = ref(<SelectOptionItems>[]);
const requiredTypeOptions = ref(<SelectOptionItems>[]);
const curriculum_name = ref('');
const category_name = ref('');
const total_count = ref(0);
const total_completed = ref(0);
const completed_percent = ref(0);
const achievement = ref([]);

const { getActiveCategory } = category();
const { getAllTakingCurriculumData, getUserAchievementInfo } = curriculum();
const { userInfo, initUser } = useAuth();

const erase = () =>
{

    eraseForm();
    requiredTypeSelect.value.clearValue();
    curriculumTypeSelect.value.clearValue();
    statusSelect.value.clearValue();

}

const search = () =>
{

    fd = new FormData;
    fd.append('user_id', userInfo.value['user_id'].toString());

    if (curriculum_name.value !== '')
    {

        fd.append('curriculum_name', curriculum_name.value);

    }

    if (category_name.value !== '')
    {

        fd.append('category_name', category_name.value);

    }

    if (requiredTypeSelect.value !== null)
    {

        if (requiredTypeSelect.value.getSelectedValue()['key'] !== undefined)
        {

            fd.append('is_required', requiredTypeSelect.value.getSelectedValue()['key']);

        }

    }

    if (curriculumTypeSelect.value !== null)
    {

        if (curriculumTypeSelect.value.getSelectedValue()['key'] !== undefined)
        {

            fd.append('curriculum_type', curriculumTypeSelect.value.getSelectedValue()['key']);

        }

    }

    if (statusSelect.value !== null)
    {

        if (statusSelect.value.getSelectedValue()['key'] !== undefined)
        {

            fd.append('status', statusSelect.value.getSelectedValue()['key']);

        }

    }

    pagingTakingCurriculumData(1);

}

const pagingTakingCurriculumData = async (page: number) =>
{

    taking_curriculum_object.value = await getAllTakingCurriculumData('user', page, fd);
    taking_curriculum_data.value = taking_curriculum_object.value['data'];
    window.scroll({ top: 0, behavior: 'smooth'});

}

const init = async () =>
{

    await initUser();

    statusOptions.value = arrangeAsSelectOptions(TakingCurriculumStatus);
    curriculumTypeOptions.value = arrangeAsSelectOptions(CurriculumType);
    requiredTypeOptions.value = arrangeAsSelectOptions(RequiredType);

    fd = new FormData;
    fd.append('user_id', userInfo.value['user_id'].toString());

    [taking_curriculum_object.value, category_data.value, achievement.value] = await Promise.all([
        getAllTakingCurriculumData('user', 1, fd),
        getActiveCategory(),
        getUserAchievementInfo(fd)
    ]);

    taking_curriculum_data.value = taking_curriculum_object.value['data'];

    total_count.value = achievement.value['total_count'];
    total_completed.value = achievement.value['total_completed'];
    completed_percent.value = achievement.value['completed_percent'];

}
init();


definePageMeta({
    layout: 'user-after-login',
    middleware: 'user',
});
</script>