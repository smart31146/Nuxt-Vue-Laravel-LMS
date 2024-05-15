<template>
<Html>
<Head>
<Title>{{ curriculum_name }}</Title>
</Head>
</Html>

<section>
    <div class="mt-60 m-auto">
       
          <section class="category table-page">
            <form class="form curriculum-form">
                <div className="p-4 text-2xl md:text-3xl text-center text-white bg-blue-600">{{ curriculum_name }}</div>
                 <div class="vieo-td w-full md:w-10/12 m-auto mt-8 curriculum-video" v-if="movie_url !== undefined">
                    
                        <MediaManagementComponent
                        media_kind="youtube"
                        :url="movie_url"
                        :is_member="true"
                        :is_completed="is_completed"
                        :user_id="user_id"
                        :curriculum_slug="curriculum_slug"
                        :content_id="content_id"
                        :startFrame="startFrame"
                        v-if="movie_url !== undefined && is_youtube"
                        :key="mediaUpdate"
                        />
                        <MediaManagementComponent
                        media_kind="vimeo"
                        :url="movie_url"
                        :is_member="true"
                        :is_completed="is_completed"
                        :user_id="user_id"
                        :curriculum_slug="curriculum_slug"
                        :content_id="content_id"
                        :startFrame="startFrame"
                        v-if="movie_url !== undefined && is_vimeo"
                        :key="mediaUpdate"
                        />
                    
                  </div>
                  <div class="flex justify-center vieo-td text-center w-full m-auto mt-8 curriculum-video" v-if="curriculum_type === '2'">
                    
                        <MediaManagementComponent
                        media_kind="audio_file"
                        :url="audio_file"
                        :is_member="true"
                        :is_completed="is_completed"
                        :user_id="user_id"
                        :curriculum_slug="curriculum_slug"
                        :content_id="content_id"
                        :startFrame="startFrame"
                        v-if="audio_file !== undefined"
                        :key="mediaUpdate"
                        />
                    
                  </div>
                <div className="mt-8 mb-4 grid grid-cols-1 lg:grid-cols-2 border border-b border-gray-400  ">
                    <div class="bg-customPink text-3xl text-center p-4 ">カテゴリ名</div>
                    <div className="text-3xl text-center p-4 lg:border-l border-gray-400">
                        {{ category_name }} / {{ is_required }}
                    </div>
                </div>
                <div className="mb-4 grid grid-cols-1 lg:grid-cols-2 border border-b border-gray-400  ">
                    <div class="bg-customPink text-3xl text-center p-4 ">PDFファイル</div>
                    <div className="text-3xl text-center p-4 lg:border-l border-gray-400">
                        <ul>
                            <li class="u-margin-bottom--0_75rem" v-if="pdf_file1 !== undefined">
                            <NuxtLink :to="pdf_file1" target="_blank" class="u-text-decoration--underline"><span class="u-font-size--1_5rem"><i class="fa fa-file-pdf"></i></span></NuxtLink>
                            </li>
                            <li class="u-margin-bottom--0_75rem" v-if="pdf_file2 !== undefined">
                            <NuxtLink :to="pdf_file2" target="_blank" class="u-text-decoration--underline"><span class="u-font-size--1_5rem"><i class="fa fa-file-pdf"></i></span></NuxtLink>
                            </li>
                            <li class="u-margin-bottom--0_75rem" v-if="pdf_file3 !== undefined">
                            <NuxtLink :to="pdf_file3" target="_blank" class="u-text-decoration--underline"><span class="u-font-size--1_5rem"><i class="fa fa-file-pdf"></i></span></NuxtLink>
                            </li>
                            <li class="u-margin-bottom--0_75rem" v-if="pdf_file4 !== undefined">
                            <NuxtLink :to="pdf_file4" target="_blank" class="u-text-decoration--underline"><span class="u-font-size--1_5rem"><i class="fa fa-file-pdf"></i></span></NuxtLink>
                            </li>
                            <li class="u-margin-bottom--0_75rem" v-if="pdf_file5 !== undefined">
                            <NuxtLink :to="pdf_file5" target="_blank" class="u-text-decoration--underline"><span class="u-font-size--1_5rem"><i class="fa fa-file-pdf"></i></span></NuxtLink>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="mb-4 grid grid-cols-1 lg:grid-cols-2 border border-b border-gray-400  ">
                    <div class="bg-customPink text-3xl text-center p-4 ">カリキュラム内容</div>
                    <div className="text-3xl text-center p-4 lg:border-l border-gray-400" v-html="curriculum_text"></div>
                </div>            
             
              <NuxtLink to="/" class="u-text-decoration--underline"><button class="m-auto w-full md:w-1/4 text-2xl py-4 mb-4 flex justify-center text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">カリキュラム一覧に戻る</button></NuxtLink>
        
              
            </form>
          </section>
      
      </div>

</section>
</template>
<script setup lang="ts">
import type { SelectOptionItems, CurriculumDirPath, Curriculum } from '@/types/index';
import { AuthorityRank, CurriculumType, RequiredType, ReleaseType } from '@/types/const';

const curriculum_data = ref<Curriculum| null>();
const curriculum_slug = ref('');
const curriculum_name_admin = ref('');
const curriculum_name = ref('');
const categoryOptions = ref(<SelectOptionItems | null>[]);
const curriculum_image = ref<string | undefined>();
const curriculum_dir_path = ref<CurriculumDirPath>();
const category_name = ref<string | null>();
const movie_url = ref<string | undefined>();
const audio_file = ref<string | undefined>();
const pdf_file = ref(false);
const pdf_file1 = ref<string | undefined>();
const pdf_file2 = ref<string | undefined>();
const pdf_file3 = ref<string | undefined>();
const pdf_file4 = ref<string | undefined>();
const pdf_file5 = ref<string | undefined>();
const curriculum_text = ref<string | null>();
const curriculum_type = ref('');
const curriculum_type_label = ref('');
const is_youtube = ref(false);
const is_vimeo = ref(false);
const authority_ranks = ref('');
const is_required = ref('');
const is_required_label = ref(false);
const release_type = ref('');
let released_at: any;
let closed_at: any;
const released_date_count = ref(0);
const closed_date_count = ref(0);
const released_time = ref<string | null>();
const closed_time = ref<string | null>();
const is_limited_release = ref(false);

const route = useRoute();
const { getActiveCategory } = category();
const { getCurriculumDirectoryPath,
    getYoutubeVideoId,
    getVimeoVideoId,
    getOneCurriculumData } = curriculum();

const setMovieURL = (item_name: string): [string | null | undefined, boolean, boolean] =>
{

    let url: string | null | undefined = undefined;
    let is_youtube: boolean = false;
    let is_vimeo: boolean = false;

    if (curriculum_data.value[item_name])
    {

        if (curriculum_data.value[item_name].includes('youtube.com'))
        {

            is_youtube = true;
            url = getYoutubeVideoId(curriculum_data.value[item_name]);

        }

        if (curriculum_data.value[item_name].includes('vimeo.com'))
        {

            is_vimeo = true;
            url = getVimeoVideoId(curriculum_data.value[item_name]);

        }

    }

    return [
        url,
        is_youtube,
        is_vimeo
    ];

}

const checkData = () =>
{

    let is_error: boolean = false;

    if (!curriculum_data.value)
    {

        is_error = true;

    }
    else
    {

        if (curriculum_data.value['status'] === 'D')
        {

            is_error = true;

        }

        if (curriculum_data.value['authority_ranks'] !== '0')
        {

            is_error = true;

        }

        if (curriculum_data.value['is_term'] === 0)
        {

            is_error = true;

        }

    }

    if (is_error)
    {

        showError({
                statusCode: 404,
                message: 'データが存在しません',
            });

    }

}

const init = async () =>
{

    const fd: FormData = new FormData();
    fd.append('curriculum_slug', route.params.curriculum_slug.toString());
    fd.append('mode', 'open');

    [categoryOptions.value, curriculum_data.value, curriculum_dir_path.value] = await Promise.all([
        getActiveCategory(),
        getOneCurriculumData(fd),
        getCurriculumDirectoryPath()
    ]);

    checkData();

    setTimeout(() =>
    {
        
        curriculum_slug.value = curriculum_data.value['curriculum_slug'];
        curriculum_name_admin.value = curriculum_data.value['curriculum_name_admin'];
        curriculum_name.value = curriculum_data.value['curriculum_name'];

        if (curriculum_data.value['curriculum_image'] !== null)
        {

            curriculum_image.value = curriculum_dir_path.value['image_path']+curriculum_data.value['curriculum_image'];

        }
        else
        {

            curriculum_image.value = curriculum_dir_path.value['no_image_path'];

        }

        for (let i = 0; i < categoryOptions.value?.length; i++)
        {

            if (parseInt(categoryOptions.value[i]['key'], 10) === curriculum_data.value['category_id'])
            {

                category_name.value = categoryOptions.value[i]['value'];

            }

        }

        CurriculumType.forEach((value, key) =>
        {

            if (key === curriculum_data.value['curriculum_type'].toString())
            {

                curriculum_type.value = key;
                curriculum_type_label.value = value;

                if (curriculum_data.value['curriculum_type'].toString() === '1')
                {

                    [ movie_url.value, is_youtube.value, is_vimeo.value ] = setMovieURL('movie_url');

                }

                if (curriculum_data.value['curriculum_type'].toString() === '2')
                {

                    if (curriculum_data.value['audio_file'] !== null)
                    {

                        audio_file.value = curriculum_dir_path.value['audio_path']+curriculum_data.value['audio_file'];

                    }

                }

            }

        });

        if (curriculum_data.value['pdf_file1'] !== null)
        {

            pdf_file.value = true;
            pdf_file1.value = curriculum_dir_path.value['pdf_path']+curriculum_data.value['pdf_file1'];

        }

        if (curriculum_data.value['pdf_file2'] !== null)
        {

            pdf_file.value = true;
            pdf_file2.value = curriculum_dir_path.value['pdf_path']+curriculum_data.value['pdf_file2'];

        }

        if (curriculum_data.value['pdf_file3'] !== null)
        {

            pdf_file.value = true;
            pdf_file3.value = curriculum_dir_path.value['pdf_path']+curriculum_data.value['pdf_file3'];

        }

        if (curriculum_data.value['pdf_file4'] !== null)
        {

            pdf_file.value = true;
            pdf_file4.value = curriculum_dir_path.value['pdf_path']+curriculum_data.value['pdf_file4'];

        }

        if (curriculum_data.value['pdf_file5'] !== null)
        {

            pdf_file.value = true;
            pdf_file5.value = curriculum_dir_path.value['pdf_path']+curriculum_data.value['pdf_file5'];

        }

        if (curriculum_data.value['curriculum_text'] !== null)
        {

            curriculum_text.value = curriculum_data.value['curriculum_text'];

        }

        let ranks: string[] = [];
        AuthorityRank.forEach((value, key) =>
        {

            let rank_values = curriculum_data.value['authority_ranks'].split(',');
            for (let i = 0; i < rank_values.length; i++)
            {

                if (key === rank_values[i].toString())
                {

                    ranks.push(value);

                }

            }


        });

        authority_ranks.value = ranks.join('、');

        RequiredType.forEach((value, key) =>
        {

            if (key === curriculum_data.value['is_required'].toString())
            {

                is_required.value = value;
                if (key === '1')
                {

                    is_required_label.value = true;

                }

            }

        });

        ReleaseType.forEach((value, key) =>
        {

            if (key === curriculum_data.value['release_type'].toString())
            {

                release_type.value = value;

                if (key === '2')
                {

                    is_limited_release.value = true;
                    released_at = dateTimeFormat(curriculum_data.value['released_at']);
                    closed_at = dateTimeFormat(curriculum_data.value['closed_at']);

                }

            }

        });

        released_date_count.value = curriculum_data.value['released_date_count'];
        closed_date_count.value = curriculum_data.value['closed_date_count'];
        released_time.value = curriculum_data.value['released_time'];
        closed_time.value = curriculum_data.value['closed_time'];

    }, 100);

}

init();

const title = computed(() => {
    return curriculum_name.value;
});
useHead({
    title,
});
definePageMeta({
    layout: 'user-before-login',
});
</script>