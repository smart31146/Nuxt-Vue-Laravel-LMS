import type { User,
    Admin,
    UserLoginInfo,
    AdminLoginInfo,
    UserResetInfo,
    AdminResetInfo,
    ContactInfo,
    UserRegistrationInfo } from "@/types";

const userInfo = ref<User | null>(null);
const admin = ref<Admin | null>(null);
const userToken = useCookie('userToken');
const adminToken = useCookie('adminToken');

export const useAuth = () =>
{

    async function getUser(): Promise<User | null>
    {

        let ret_user = null;

        if (userInfo.value)
        {
            ret_user = userInfo.value;
        }
        else
        {

            await useApi(apiURL('user/get_by_token'),
            {
                method: 'POST',
                baseURL: getBaseURL(),
                body: {
                    token: userToken.value,
                },
                onResponse({request, response}) {
    
                    if (response.status === 200)
                    {
    
                        ret_user = response._data.user;
    
                    }
    
                }
            });

        }

        return ret_user;

    }

    async function getAdmin(): Promise<Admin | null>
    {

        let ret_user = null;

        if (admin.value)
        {
            ret_user = admin.value;
        }
        else
        {

            await useApi(apiURL('service-admin/get_by_token'),
            {
                method: 'POST',
                baseURL: getBaseURL(),
                body: {
                    token: adminToken.value,
                },
                onResponse({request, response}) {
    
                    if (response.status === 200)
                    {
    
                        ret_user = response._data.admin;
    
                    }
    
                }
            });

        }

        return ret_user;

    }

    async function initUser()
    {
        userInfo.value = await getUser();
    }

    async function initAdmin()
    {
        admin.value = await getAdmin();
    }

    async function userLogin(loginInfo: UserLoginInfo): Promise<string>
    {

        let error = '';

        await useApi(apiURL('user/login'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: loginInfo,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);

            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    userInfo.value = response._data.user;
                    userToken.value = response._data.token;
                    useRouter().push('/user/dashboard');

                }

            }

        });

        return error;

    }

    async function userLogout()
    {

        await useApi(apiURL('user/logout'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: userInfo.value
        });
        userInfo.value = null;
        userToken.value = null;
        useRouter().replace('/');

    }

    async function adminLogin(loginInfo: AdminLoginInfo): Promise<string>
    {

        let error = '';

        await useApi(apiURL('service-admin/login'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: loginInfo,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);
                
            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    admin.value = response._data.admin;
                    adminToken.value = response._data.token;
                    useRouter().push('/service-admin/dashboard');

                }

            }

        });

        return error;

    }

    async function adminLogout()
    {

        await useApi(apiURL('service-admin/logout'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: admin.value
        });
        admin.value = null;
        adminToken.value = null;
        useRouter().replace('/service-admin');

    }

    async function userRegistration(registrationInfo: UserRegistrationInfo): Promise<string>
    {

        let error = '';

        await useApi(apiURL('user/registration'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: registrationInfo,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);

            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    useRouter().replace('/user/registration/complete');

                }

            }
        });

        return error;

    }

    async function userPasswordReset(resetInfo: UserResetInfo): Promise<string>
    {

        let error = '';

        await useApi(apiURL('user/password/reset'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: resetInfo,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);
                
            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    useRouter().push('/user/passwords/reset');

                }

            }

        });

        return error;

    }

    async function adminPasswordReset(resetInfo: AdminResetInfo): Promise<string>
    {

        let error = '';

        await useApi(apiURL('service-admin/password/reset'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: resetInfo,
            onResponseError({request, response})
            {

                error = handleInvalidForm(response);
                
            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    useRouter().push('/service-admin/passwords/reset');

                }

            }

        });

        return error;

    }

    async function contact(contactInfo: ContactInfo): Promise<string>
    {

        let ret = '';

        await useApi(apiURL('contact'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: contactInfo,
            onResponseError({request, response})
            {

                ret = handleInvalidForm(response);
                
            },
            onResponse({request, response}) {

                if (response.status === 200)
                {

                    useRouter().push('/contact/complete');

                }

            }

        });

        return ret;

    }

    async function userWithdrawal()
    {

        await useApi(apiURL('user/withdrawal'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: userInfo.value
        });
        userInfo.value = null;
        userToken.value = null;
        useRouter().replace('/user/login');

    }

    async function getUserAuth(): Promise<void>
    {

        const { data } = await useApi(apiURL('user/check-user-auth'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: {
                token: userToken.value,
            },
        });

        if (!data._value['result'])
        {

            userInfo.value = null;
            userToken.value = null;
            useRouter().replace('/user/login');

        }

    }

    function initUerToken(token: string):void
    {
        userToken.value = token;
    }

    return {
        userLogin,
        userLogout,
        userRegistration,
        adminLogin,
        adminLogout,
        initUser,
        initAdmin,
        userPasswordReset,
        adminPasswordReset,
        contact,
        userWithdrawal,
        userInfo,
        getUserAuth,
        initUerToken,
        admin
    };
};