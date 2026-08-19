import { LinkButton } from '@/common/components/link-button';
import type { SharedData } from '@/common/types/shared-data';
import { AppLogoIcon } from '@/modules/app-shell/components/app-logo-icon';
import { dashboard, login, register } from '@/routes';
import { Head, usePage } from '@inertiajs/react';

export default function WelcomePage({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth, name } = usePage<SharedData>().props;

    return (
        <>
            <Head title="Welcome" />
            <div className="flex min-h-screen flex-col items-center justify-center gap-8 bg-background p-6 text-foreground lg:p-8">
                <div className="flex flex-col items-center gap-4 text-center">
                    <div className="flex size-14 items-center justify-center rounded-xl bg-primary text-primary-foreground">
                        <AppLogoIcon className="size-8 fill-current" />
                    </div>
                    <div className="space-y-2">
                        <h1 className="text-3xl font-semibold tracking-tight">
                            {name}
                        </h1>
                        <p className="max-w-md text-sm text-muted-foreground">
                            This is the tenant welcome page. Replace it with
                            your own landing page, or point the{' '}
                            <code className="rounded bg-muted px-1 py-0.5 font-mono text-xs">
                                home
                            </code>{' '}
                            route somewhere else in{' '}
                            <code className="rounded bg-muted px-1 py-0.5 font-mono text-xs">
                                routes/tenant.php
                            </code>
                            .
                        </p>
                    </div>
                </div>

                <nav className="flex flex-wrap items-center justify-center gap-3">
                    {auth.user ? (
                        <LinkButton href={dashboard().url}>
                            Go to dashboard
                        </LinkButton>
                    ) : (
                        <>
                            <LinkButton href={login().url}>Log in</LinkButton>
                            {canRegister && (
                                <LinkButton
                                    href={register().url}
                                    variant="outline"
                                >
                                    Register
                                </LinkButton>
                            )}
                        </>
                    )}
                </nav>
            </div>
        </>
    );
}
