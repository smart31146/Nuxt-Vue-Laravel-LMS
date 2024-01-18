import type {
    Admin
} from "@/types";

export const admin = () =>
{

    async function storeAdmin(url: string, fd: FormData): Promise<string>
    {

        let error = '';

        await useApi(apiURL('service-admin/'+url),
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

                    useRouter().push('/service-admin/account/'+url);

                }

            }

        });

        return error;

    }

    async function getAllAdminData(page: number, fd?: FormData): Promise<Object | null>
    {

        const { data } = await useApi(apiURL(`service-admin/get-all-admin-data?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/account');

            }
        });

        return data._value;

    }

    async function destroyAdmin(fd: FormData): Promise<void>
    {

        await useApi(apiURL('service-admin/destroy'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/account/destroy');

            }
        });

    }

    async function recoverAdmin(fd: FormData): Promise<void>
    {

        await useApi(apiURL('service-admin/recover'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/account/recover');

            }
        });

    }

    async function getOneAdminData(fd: FormData): Promise<Admin>
    {

        const { data } = await useApi(apiURL('service-admin/show'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const admin: Admin = data._value;
        return admin;

    }

    return {
        storeAdmin,
        getAllAdminData,
        destroyAdmin,
        recoverAdmin,
        getOneAdminData
    };

} 