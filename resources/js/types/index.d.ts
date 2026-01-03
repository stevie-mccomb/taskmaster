import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface Model {
    id: number;
    created_at: string;
    updated_at: string;
};

export interface Project extends Model {
    user_id: number;
    name: string;
    slug: string;
    user?: User;
};

export interface TaskStatus extends Model {
    name: string;
    slug: string;
    border_style: string;
    color_background: string;
    color_border: string;
    color_text: string;
};

export interface Task extends Model {
    project_id: number;
    task_status_id: number;
    user_id: number;
    title: string;
    content: string;
    priority: number;
    project?: Project;
    task_status?: TaskStatus;
    user?: User;
};

export interface User extends Model {
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    projects?: Project[];
}

export type BreadcrumbItemType = BreadcrumbItem;
