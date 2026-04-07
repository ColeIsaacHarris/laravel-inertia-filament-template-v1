import {
    Separator as AriaSeparator,
    type SeparatorProps,
} from 'react-aria-components';
import { tv } from 'tailwind-variants';

const separatorStyles = tv({
    base: 'shrink-0 bg-border',
    variants: {
        orientation: {
            horizontal: 'h-px w-full',
            vertical: 'h-full w-px',
        },
    },
    defaultVariants: {
        orientation: 'horizontal',
    },
});

function Separator({ className, ...props }: SeparatorProps) {
    return (
        <AriaSeparator
            className={separatorStyles({
                orientation: props.orientation,
                className: className as string,
            })}
            {...props}
        />
    );
}

export { Separator };
