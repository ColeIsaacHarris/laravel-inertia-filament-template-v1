import type { BreadcrumbItem as BreadcrumbItemType } from '@/common/types/navigation';
import { ChevronRight } from 'lucide-react';
import {
    Breadcrumb,
    Link,
    Breadcrumbs as RACBreadcrumbs,
} from 'react-aria-components';

export function Breadcrumbs({
    breadcrumbs,
}: {
    breadcrumbs: BreadcrumbItemType[];
}) {
    return (
        <>
            {breadcrumbs.length > 0 && (
                <RACBreadcrumbs
                    items={breadcrumbs.map((item, index) => ({
                        ...item,
                        id: index,
                        isCurrent: index === breadcrumbs.length - 1,
                    }))}
                    className="flex flex-wrap items-center gap-1.5 text-sm break-words text-muted-foreground sm:gap-2.5"
                >
                    {(item) => (
                        <Breadcrumb className="inline-flex items-center gap-1.5">
                            <Link
                                href={item.isCurrent ? undefined : item.href}
                                className={
                                    item.isCurrent
                                        ? 'font-normal text-foreground'
                                        : 'transition-colors data-hovered:text-foreground'
                                }
                            >
                                {item.title}
                            </Link>
                            {!item.isCurrent && (
                                <ChevronRight className="size-3.5" />
                            )}
                        </Breadcrumb>
                    )}
                </RACBreadcrumbs>
            )}
        </>
    );
}
