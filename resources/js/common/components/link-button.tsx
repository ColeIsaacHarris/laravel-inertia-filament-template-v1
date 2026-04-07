import {
    Link as RACLink,
    type LinkProps as RACLinkProps,
    composeRenderProps,
} from 'react-aria-components';
import type { VariantProps } from 'tailwind-variants';

import { buttonStyles } from '@/common/components/button';

type ButtonVariants = VariantProps<typeof buttonStyles>;

interface LinkButtonProps extends RACLinkProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
}

function LinkButton({ variant, size, ...props }: LinkButtonProps) {
    return (
        <RACLink
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    buttonStyles({
                        ...renderProps,
                        variant,
                        size,
                        className,
                    }),
            )}
        />
    );
}

export { LinkButton, type LinkButtonProps };
