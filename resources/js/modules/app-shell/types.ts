import type { BreadcrumbItem } from '@/common/types/navigation';
import type { ReactNode } from 'react';

export type AppLayoutProps = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};
