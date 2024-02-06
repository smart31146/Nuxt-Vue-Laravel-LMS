import type {
    Curriculum,
    CurriculumDirPath,
    CurriculumData,
    PaginatedResponse,
    SelectOptionItems,
    RequestCertificateData,
    TakingCurriculum} from "@/types";
import { Certificate } from "crypto";

const parentCategoryValue = ref(<SelectOptionItems | null>null);

export const curriculum = () =>
{

    async function storeCurriculum(url: string, fd: FormData): Promise<string>
    {

        let error = '';

        await useApi(apiURL('curriculums/'+url),
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

                    useRouter().push('/service-admin/curriculums/'+url);

                }

            }

        });

        return error;

    }

    async function getAllCurriculumData(mode: string, page: number, fd?: FormData): Promise<PaginatedResponse<CurriculumData> | null | undefined>
    {

        const { data } = await useApi(apiURL(`curriculums/get-all-curriculum-data?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse()
            {

                if (mode === 'service-admin')
                {

                    // useRouter().push('/service-admin/curriculums');

                }

                if (mode === 'user')
                {

                    // useRouter().push('/user/dashboard');

                }

                if (mode === 'open')
                {

                    // useRouter().push('/');

                }

            }
        });

        return data._value;

    }

    async function destroyCurriculum(fd: FormData): Promise<void>
    {

        await useApi(apiURL('curriculums/destroy'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/curriculums/destroy');

            }
        });

    }

    async function recoverCurriculum(fd: FormData): Promise<void>
    {

        await useApi(apiURL('curriculums/recover'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse({request, response})
            {

                useRouter().push('/service-admin/curriculums/recover');

            }
        });

    }

    async function getOneCurriculumData(fd: FormData): Promise<Curriculum>
    {

        const { data } = await useApi(apiURL('curriculums/show'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const curriculum: Curriculum = data._value;
        return curriculum;

    }

    async function getCurriculumDirectoryPath(): Promise<CurriculumDirPath>
    {

        const { data } = await useApi(apiURL('curriculums/get-directory-path'),
        {
            method: 'GET',
            baseURL: getBaseURL(),
        });

        const dir: CurriculumDirPath = data._value;
        return dir;

    }

    const getYoutubeVideoId = (url: string) =>
    {

        let videoId: string = '';

        const query = url.split('?');
        const param = query[1].split('&');

        for (let i = 0; i < param.length; i++)
        {

            let pair = param[i].split('=');
            if (pair[0] === 'v')
            {

                videoId = pair[1];
                break;

            }

        }

        return videoId;

    }

    const getVimeoVideoId = (url: string) =>
    {

        let videoId: string = url.replace('https://vimeo.com/', '');
        videoId = videoId.replace('https://www.vimeo.com/', '');

        return videoId;

    }

    async function takingCurriculum(fd: FormData): Promise<void>
    {

        await useApi(apiURL('curriculums/take'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
        });

    }

    async function getOneTakingCurriculumData(fd: FormData): Promise<TakingCurriculum | null>
    {

        const { data } = await useApi(apiURL('curriculums/get-one-taking-curriculum'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });
        const takingCurriculum: TakingCurriculum = data._value;
        return takingCurriculum;

    }

    async function getAllTakingCurriculumData(mode: string, page: number, fd: FormData, user_id?: number): Promise<PaginatedResponse<TakingCurriculum> | null | undefined>
    {

        const { data } = await useApi(apiURL(`curriculums/get-all-taking-curriculum-data?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse()
            {

                if (mode === 'service-admin')
                {

                    useRouter().push('/service-admin/curriculums');

                }

                if (mode === 'user')
                {

                    useRouter().push('/user/curriculums');

                }

                if (mode === 'progress')
                {

                    useRouter().push('/service-admin/user/progress/'+user_id);

                }

            }
        });

        return data._value;

    }

    async function getCertificate(fd: FormData): Promise<Certificate | null>
    {

        const { data } = await useApi(apiURL('curriculums/get-certificate'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        const certificate: Certificate = data._value;
        return certificate;

    }

    async function requestCertificate(fd: FormData): Promise<void>
    {

        await useApi(apiURL('curriculums/request-certificate'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse()
            {

                useRouter().push('/user/certifications/request');

            }

        });

    }

    async function updateCertificate(fd: FormData): Promise<void>
    {

        await useApi(apiURL('curriculums/update-certificate'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd,
            onResponse()
            {

                useRouter().push('/service-admin/curriculums/certificate');

            }

        });

    }

    async function getRequiredCurriculumStatus(fd: FormData): Promise<boolean>
    {

        const { data } = await useApi(apiURL('curriculums/get-required-curriculum-status'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        return data._value.result;

    }

    async function getRequestCertificate(page: number): Promise<PaginatedResponse<RequestCertificateData> | null | undefined>
    {

        const { data } = await useApi(apiURL(`curriculums/get-request-certificate?page=${page}`),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            onResponse()
            {

                useRouter().push('/service-admin/dashboard');

            }
        });

        return data._value;

    }

    async function getUserAchievementInfo(fd: FormData): Promise<Object>
    {

        const { data } = await useApi(apiURL('curriculums/get-user-achievement-info'),
        {
            method: 'POST',
            baseURL: getBaseURL(),
            body: fd
        });

        return data._value;

    }

    return {
        storeCurriculum,
        getAllCurriculumData,
        destroyCurriculum,
        recoverCurriculum,
        getOneCurriculumData,
        getCurriculumDirectoryPath,
        getYoutubeVideoId,
        getVimeoVideoId,
        takingCurriculum,
        getOneTakingCurriculumData,
        getAllTakingCurriculumData,
        getCertificate,
        requestCertificate,
        updateCertificate,
        getRequiredCurriculumStatus,
        getRequestCertificate,
        getUserAchievementInfo,
        parentCategoryValue
    };

} 