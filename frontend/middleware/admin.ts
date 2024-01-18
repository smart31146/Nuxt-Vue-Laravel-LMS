export default defineNuxtRouteMiddleware(async (to, from) =>
{

    const { admin, initAdmin } = useAuth();
    await initAdmin();

    if (!admin.value)
    {
        return navigateTo('/service-admin');
    }

});