import type {
    User
} from "@/types";
import type { SelectOptionItems } from '@/types/index';
const { initUerToken } = useAuth();

export const user = () =>
{

    async function storeUser(url: string, fd: FormData, is_user?: boolean): Promise<string>
    {

        let error = '';

        await useApi(apiURL('user/'+url),
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

                    if (is_user)
                    {

                        if (response._data['token'] !== '')
                        {

                            initUerToken(response._data['token']);

                        }

                        useRouter().push('/user/profile');

                    }
                    else
                    {

                        useRouter().push('/service-admin/user/'+url);

                    }

                }

            }

        });

        return error;

    }

    async function getAllUserData(page: number, fd?: FormData): Promise<Object | null>
    {

        const { data } = await useApi(apiURL(`user/get-all-user-data?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/user');

            }
        });

        return data._value;

    }

    async function destroyUser(fd: FormData): Promise<void>
    {

        await useApi(apiURL('user/destroy'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/user/destroy');

            }
        });

    }

    async function recoverUser(fd: FormData): Promise<void>
    {

        await useApi(apiURL('user/recover'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/user/recover');

            }
        });

    }

    async function getOneUserData(fd: FormData): Promise<User>
    {

        const { data } = await useApi(apiURL('user/show'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const user: User = data._value;
        return user;

    }

    async function getAddressInfo(zip: string, options: SelectOptionItems | null): Promise<{ prefecture: number | string | Object | undefined, address: string }>
    {
    
        let prefecture: number | string | Object | undefined = undefined;
        let address: string = '';

        if (zip.length >= 7)
        {
    
            const fd: FormData = new FormData();
            fd.append('zip', zip);

            const { data } = await useApi(apiURL('user/get-address'),
            {
                method: 'POST',
                baseURL: getBaseURL(),
                body: fd,
            });

            if (data._value['code'] === 200)
            {

                for (let i = 0; i < options.length; i++)
                {

                    if (options[i]['value'] === data._value['data']['pref'])
                    {

                        prefecture = options[i];

                    }

                }

                address = data._value['data']['address'];

            }

        }

        return {
            prefecture,
            address
        };
    
    }

    return {
        storeUser,
        getAllUserData,
        destroyUser,
        recoverUser,
        getAddressInfo,
        getOneUserData
    };

} 