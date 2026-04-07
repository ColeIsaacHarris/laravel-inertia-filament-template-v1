import { initializeTheme } from '@/common/hooks/use-appearance';
import { createInertiaApp, router } from '@inertiajs/react';
import { RouterProvider } from 'react-aria-components';
import '../css/app.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    strictMode: true,
    progress: {
        color: '#4B5563',
    },
    withApp(app) {
        return (
            <RouterProvider navigate={(to, opts) => router.visit(to, opts)}>
                {app}
            </RouterProvider>
        );
    },
});

// This will set light / dark mode on load...
initializeTheme();
