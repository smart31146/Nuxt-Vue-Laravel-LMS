export const apiURL = (dest: string, params?: Object): string =>
{

    let url = getBaseURL()+`/api/${dest}`;
    if (typeof params !== 'undefined')
    {

        if (Object.keys(params).length > 0)
        {

            let query_array: Array<String> = [];
            Object.entries(params).forEach(([key, value]) =>
            {
                query_array.push(key+'='+value);
            });

            url += '?'+query_array.join('&');

        }

    }

    return url;

}

export const getBaseURL = (): string =>
{
    const config = useRuntimeConfig();
    return config.public.apiUrl;
}