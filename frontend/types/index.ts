export interface User
{
    user_id: number;
    user_email: string;
    user_name: string;
    sei: string | null;
    mei: string | null;
    sei_kana: string | null;
    mei_kana: string | null;
    sex: string | null;
    tel: string | null;
    zip: string | null;
    prefecture: number | null;
    address_01: string | null;
    address_02: string | null;
    user_rank: number;
    user_type: number;
    status: string;
    created_at: Date;
    updated_at: Date;
}

export interface UserData extends Array<User>{};

export interface Admin
{
    admin_id: number;
    admin_email: string;
    admin_name: string;
    admin_type: number;
    status: string;
    start_date: string;
    end_date: string | null;
    created_at: Date;
    updated_at: Date;
}

export interface AdminData extends Array<Admin>{};

export interface Category
{
    category_id: number;
    category_slug: string;
    category_name_admin: string;
    category_name: string;
    category_level: string,
    parent_id: number | null;
    category_image: string | null;
    category_text: string;
    status: string;
    created_at?: Date;
    updated_at?: Date;
}

export interface CategoryData extends Array<Category>{};

export interface ParentCategory
{
    category_id: number;
    category_name: string;
}

export interface ParentCategoryData extends Array<ParentCategory>{};

export interface Certificate
{
    certificate_id: number;
    user_id: number;
    status: string;
    certified_date: Date;
    created_at: Date;
    updated_at: Date;
}

export interface CertificateData extends Array<Certificate>{};

export interface RequestCertificate
{
    user_id: number;
    user_name: string;
    created_at: Date;
    certified_date: Date;
    status: string;
}

export interface RequestCertificateData extends Array<RequestCertificate>{};

export interface Curriculum
{
    curriculum_id: number;
    curriculum_slug: string;
    curriculum_name_admin: string;
    curriculum_name: string;
    curriculum_image: string | null;
    category_id: number;
    category_name: string;
    curriculum_type: string;
    authority_ranks: string;
    curriculum_text: string | null;
    movie_url: string | null;
    audio_file: string | null;
    pdf_file1: string | null;
    pdf_file2: string | null;
    pdf_file3: string | null;
    pdf_file4: string | null;
    pdf_file5: string | null;
    is_required: boolean;
    release_type: string;
    released_at: string | null;
    closed_at: string | null;
    released_date_count: number;
    released_time: string | null;
    closed_date_count: number;
    closed_time: string | null;
    status: string;
    is_term?: number;
    is_limited_user?: number;
    created_at: Date;
    updated_at: Date;
}

export interface CurriculumData extends Array<Curriculum>{};

export interface  TakingCurriculum
{
    curriculum_slug: string;
    curriculum_name: string;
    category_name: string;
    curriculum_type: string;
    is_required: boolean;
    started_at: Date;
    completed_at: Date;
    taking_curriculum_second: number;
    total_curriculum_second: number;
    status: string;
}

export interface TakingCurriculumData extends Array<TakingCurriculum>{};

export interface UserLoginInfo
{
    user_email: string;
    password: string;
}

export interface AdminLoginInfo
{
    admin_email: string;
    password: string;
}

export interface UserResetInfo
{
    user_email: string;
}

export interface AdminResetInfo
{
    admin_email: string;
}

export interface UserRegistrationInfo
{
    user_name: string;
    user_email: string;
    password: string;
    password_confirmation: string;
}

export interface PaginatedResponse<T>
{
    current_page: number;
    data: T;
    first_page_url: string | null;
    from: number;
    last_page: number;
    last_page_url: string | null;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

export interface PaginateMeta<T>
{
    data: PaginatedResponse<T> | undefined | null;
    limit: number;
    keepLength: boolean;
}

export interface ContactInfo
{
    your_name: string;
    your_email: string;
    your_body: string;
}

export interface SelectOption
{
    key: string;
    value: string | number;
}

export interface SelectOptionItems extends Array<SelectOption>{};

export interface SelectComponent
{
    item_name: string;
    defaultValue: number | string | Object | undefined;
    data: SelectOptionItems | null;
}

export interface RadioButtonComponent
{
    item_name: string;
    defaultValue: string | undefined;
    data: SelectOptionItems | null;
}

export interface CheckboxComponent
{
    item_name: string;
    defaultValue: Array<string> | undefined;
    data: SelectOptionItems | null;
}

export interface CurriculumDirPath
{
    audio_path: string;
    pdf_path: string;
    image_path: string;
    no_image_path: string;
}

export interface EmbedOptions
{
    url: string | undefined;
    is_member: boolean;
    media_kind: string;
    user_id?: number;
    curriculum_slug?: string,
    startFrame?: number;
    is_completed?: boolean;
    content_id?: string;
}

export interface MediaMeta
{
    url: string | undefined;
    startFrame?: number;
    is_seeker?: boolean;
}

export interface CardCurriculum
{
    mode: string;
    curriculum_slug: string;
    curriculum_name: string;
    category_name: string;
    curriculum_image: string | null | undefined;
    image_path: string;
    no_image_path: string;
    take_status?: string;
}

export type DataType = CurriculumData | CategoryData | UserData |
                        AdminData | TakingCurriculum | RequestCertificateData;