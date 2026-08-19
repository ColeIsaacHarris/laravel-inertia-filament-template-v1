import type { SVGAttributes } from 'react';

/**
 * Placeholder application mark. Replace the paths with your own logo — every
 * call site styles it with `fill-current`, so keep the shape fill-driven and
 * the viewBox square.
 */
export function AppLogoIcon(props: SVGAttributes<SVGElement>) {
    return (
        <svg {...props} viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path
                fillRule="evenodd"
                clipRule="evenodd"
                d="M20 0 40 11.5v17L20 40 0 28.5v-17L20 0Zm0 4.62L4 13.83v12.34l16 9.21 16-9.21V13.83L20 4.62Zm0 6.92 10 5.77v11.54l-4-2.31v-6.92l-6-3.46-6 3.46v6.92l-4 2.31V17.31l10-5.77Z"
            />
        </svg>
    );
}
