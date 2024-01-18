import { FetchOptions } from 'ohmyfetch';

const csrf_cookie: string = 'XSRF-TOKEN';
export const useFetchCookies = async (serverRoute: string) => {

	await $fetch.raw('/sanctum/csrf-cookie', {
		baseURL: serverRoute,
		credentials: 'include'
	});
};

export const useApi = async (url: string, options?: FetchOptions) =>
{

	const config = useRuntimeConfig();

	const serverRoute: string = config.public.apiUrl;
	const apiRoute: string = `${serverRoute}/api`;
	let token = useCookie(csrf_cookie)?.value;

	if (!token) {

		await useFetchCookies(serverRoute);
		token = useCookie(csrf_cookie).value;

	}

	const headers: HeadersInit = {
		Accept: 'application/json',
		'Cache-Control': 'no-cache',
		'X-XSRF-TOKEN': token,
		...options?.headers
	};

	const opts: FetchOptions = options ? (({ headers, ...opts }) => opts)(options) : null;
	const baseURL = !options?.baseURL ? apiRoute : options.baseURL;

	return useFetch(url, {
		baseURL: baseURL,
		credentials: 'include',
		headers,
		...opts
	});
};