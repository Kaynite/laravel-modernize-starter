import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    config: UserConfig;
}

export interface UserConfig {
    mini_sidebar: boolean;
    theme: string;
    locale: string;
    is_horizontal: boolean;
    is_rtl: boolean;
    is_boxed: boolean;
    is_card_bordered: boolean;
}

export interface PaginatedCollection<Model> {
    data: Model[],
    links: object
    meta: {
        current_page: number;
        from: number;
        last_page: number;
        per_page: number;
        to: number;
        total: number;
    }
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
    flash: {
        success: any;
        danger: any;
    }
};
