import { AuthSimpleLayout as AuthLayoutTemplate } from '@/modules/auth/layouts/auth-simple-layout';

export function AuthLayout({
    children,
    title,
    description,
    ...props
}: {
    children: React.ReactNode;
    title: string;
    description: string;
}) {
    return (
        <AuthLayoutTemplate title={title} description={description} {...props}>
            {children}
        </AuthLayoutTemplate>
    );
}
