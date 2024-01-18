export default defineNuxtRouteMiddleware(async (to, from) =>
{

    const { userInfo, initUser, getUserAuth } = useAuth();
    await initUser();

    if (!userInfo.value)
    {
        return navigateTo('/user/login');
    }

    getUserAuth();

});