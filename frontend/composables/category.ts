import type {
    Category,
    SelectOptionItems } from "@/types";

const parentCategoryValue = ref<SelectOptionItems | null>();

export const category = () =>
{

    async function getParentCategory(fd?: FormData): Promise<SelectOptionItems | null>
    {

        const { data } = await useApi(apiURL('categories/get-parent-categories'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const categories: SelectOptionItems | null  = data._value.categories;

        return categories;

    }

    async function storeCategory(url: string, fd: FormData): Promise<string>
    {

        let error = '';

        await useApi(apiURL('categories/'+url),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);
                
            },
            onResponse({request, response})
            {

                if (response.status === 200)
                {

                    useRouter().push('/service-admin/categories/'+url);

                }

            }

        });

        return error;

    }

    async function getAllCategoryData(page: number, fd?: FormData): Promise<Object | null>
    {

        const { data } = await useApi(apiURL(`categories/get-all-category-data?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                // useRouter().push('/service-admin/categories');

            }
        });

        return data._value;

    }

    function setCategoryName(parent_id: number | null, categoryList: SelectOptionItems | null | undefined): string
    {

        let ret: string = '';

        if (categoryList !== null)
        {

            if (parent_id !== null)
            {

                for (let i = 0; i < categoryList?.length; i++)
                {

                    if (parseInt(categoryList[i]['key'], 10) === parent_id)
                    {

                        ret = categoryList[i]['value'] as string;

                    }

                }

            }

        }

        return ret;

    }

    async function destroyCategory(fd: FormData): Promise<void>
    {

        await useApi(apiURL('categories/destroy'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/categories/destroy');

            }
        });

    }

    async function recoverCategory(fd: FormData): Promise<void>
    {

        await useApi(apiURL('categories/recover'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/categories/recover');

            }
        });

    }

    async function getOneCategoryData(fd: FormData): Promise<Category>
    {

        const { data } = await useApi(apiURL('categories/show'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const category: Category = data._value;
        return category;

    }

    async function getCategoryDirectoryPath(): Promise<string>
    {

        const { data } = await useApi(apiURL('categories/get-directory-path'),
        {
            method: 'GET',
            baseURL: getBaseURL(),
        });

        return data._value;

    }

    async function getActiveCategory(): Promise<SelectOptionItems | null>
    {

        const { data } = await useApi(apiURL('categories/get-active-categories'),
        {
            method: 'GET',
            baseURL: getBaseURL(),
        });

        const categories: SelectOptionItems | null  = data._value.categories;

        return categories;

    }


    return {
        getParentCategory,
        storeCategory,
        getAllCategoryData,
        setCategoryName,
        destroyCategory,
        recoverCategory,
        getOneCategoryData,
        getCategoryDirectoryPath,
        getActiveCategory,
        parentCategoryValue
    };

} 