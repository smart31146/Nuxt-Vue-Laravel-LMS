<template>
<Html>
<Head>
<Title>受講履歴</Title>
</Head>
</Html>

<section>
    
      <div class="m-auto mt-48">
        <div class="inner">
          <section class="category table-page">
            <h1 class="sec-title curriculum-title">受講履歴</h1>
            <form class="form curriculum-form">
              <div className="mb-8 grid grid-cols-1 lg:grid-cols-2 border-l border-r border-b border-gray-400  ">
                <div className="text-2xl border-t border-gray-400 bg-customPink p-4"> カリキュラム名 </div>
                  
                  <div className="lg:border-l border-t border-gray-400 p-4"> <input
                    type="search"
                    v-model="curriculum_name"
                    class="w-full text-3xl"
                    id="curriculum-name"
                    name="curriculum-name"
                  /></div>
                  <div className="text-2xl border-t border-gray-400 bg-customPink p-4"> カテゴリ名 </div>
                    
                  <div className="lg:border-l border-t border-gray-400 p-4"> <input
                    type="search"
                    v-model="category_name"
                    class="w-full text-3xl"
                    id="category-name"
                    name="category-name"
                  /></div>
                  <div className="text-2xl border-t  border-gray-400 bg-customPink p-4"> 必修/任意 </div>
                    
                  <div className="lg:border-l border-t  border-gray-400 p-2"> 
                  <SelectComponent
                          ref="requiredTypeSelect"
                          item_name="required_type"
                          defaultValue=""
                          :data="requiredTypeOptions"
                        />
                  </div> 
                  <div className="text-2xl border-t border-gray-400 bg-customPink p-4"> 
                  カリキュラム種別 </div>
                    
                  <div className="lg:border-l border-t border-gray-400 p-2"> 
                   <SelectComponent
                        ref="curriculumTypeSelect"
                        item_name="curriculum_type"
                        defaultValue=""
                        :data="curriculumTypeOptions"
                      />
                  </div> 
                  <div className="text-2xl border-t border-gray-400 bg-customPink p-4"> 
                  状態 </div>
                    
                  <div className="lg:border-l border-t border-gray-400 p-2"> 
                    <SelectComponent
                        ref="statusSelect"
                        item_name="status"
                        defaultValue=""
                        :data="statusOptions"
                      />
                  </div>   
                </div>

              
              <button class="serch-btn" @click.prevent="search">
                <i class="fa-solid fa-magnifying-glass fa-icon"></i>
              </button>
            </form>
            <p class="text-[15px] mb-2 ">受講可能な必修受講総数: {{ total_count }}、完了数: {{ total_completed }}、達成率: {{ completed_percent }}% </p>
            <div class="overflow-x-auto mt-4 w-full">
            
                <table class="overflow-x-auto text-[10px] text-center border-2 border-customPink bg-white min-w-screen ">
                  <thead>
                    <tr class="p-2 h-[30px] text-[20px] text-customPink bg-[#5199f8] whitespace-nowrap text-white">
                        <th class="px-3 py-1 border border-customPink">カリキュラム名</th>
                        <th class="px-3 py-1 border border-customPink">カテゴリ名</th>
                        <th class="px-3 py-1 border border-customPink">カリキュラム種別</th>
                        <th class="px-3 py-1 border border-customPink">必修/任意</th>
                        <th class="px-3 py-1 border border-customPink">受講開始日時</th>
                        <th class="px-3 py-1 border border-customPink">受講終了日時</th>
                        <th class="px-3 py-1 border border-customPink">進捗状況</th>
                        <th class="px-3 py-1 border border-customPink">状態</th>
                        <th class="px-3 py-1 border border-customPink"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="p-2 h-[30px] "v-for="(item, i) in taking_curriculum_data" :key="i">
                        <td class="px-3 py-1 border border-customPink"><NuxtLink :to="`/user/curriculums/${item.curriculum_slug}`" class="u-text-decoration--underline">{{ item.curriculum_name }}</NuxtLink></td>
                        <td class="px-3 py-1 border border-customPink">{{ item.category_name }}</td>
                        <td class="px-3 py-1 border border-customPink">{{ CurriculumType.get(item.curriculum_type.toString()) }}</td>
                        <td class="px-3 py-1 border border-customPink">{{ RequiredType.get(item.is_required.toString()) }}</td>
                        <td class="px-3 py-1 border border-customPink">{{ dateTimeFormat(item.started_at).value }}</td>
                        <td class="px-3 py-1 border border-customPink">{{ item.completed_at ? dateTimeFormat(item.completed_at).value  : '' }}</td>
                        <td class="px-3 py-1 border border-customPink">{{ getPercentage(item.taking_curriculum_second, item.total_curriculum_second) }}%</td>
                        <td class="px-3 py-1 border border-customPink">{{ TakingCurriculumStatus.get(item.status) }}</td>
                        <td class="px-3 py-1 border border-customPink">
                        <ul class="flex gap-1">
                          <li>
                            <NuxtLink :to="`/user/curriculums/${item.curriculum_slug}`">
                                <i class="fa-solid fa-circle-info fa-icon"></i
                            ></NuxtLink>
                          </li>
                          
                        </ul>
                      </td>
                    </tr>
                  </tbody>
                </table>
           
            </div>
          </section>
        </div>
      </div>
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
import globlaStore from "@/store";
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
    console.log("test taking",taking_curriculum_data)
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