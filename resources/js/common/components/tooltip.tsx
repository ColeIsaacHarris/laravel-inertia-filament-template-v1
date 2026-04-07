import {
    Tooltip as RACTooltip,
    type TooltipProps as RACTooltipProps,
    TooltipTrigger,
    composeRenderProps,
} from 'react-aria-components';
import { tv } from 'tailwind-variants';

const tooltipStyles = tv({
    base: 'z-50 overflow-hidden rounded-md bg-primary px-3 py-1.5 text-xs text-primary-foreground shadow-md',
    variants: {
        isEntering: {
            true: 'animate-in fade-in zoom-in-95 duration-150',
        },
        isExiting: {
            true: 'animate-out fade-out zoom-out-95 duration-150',
        },
    },
});

function Tooltip({ children, ...props }: RACTooltipProps) {
    return (
        <RACTooltip
            offset={8}
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    tooltipStyles({ ...renderProps, className }),
            )}
        >
            {children}
        </RACTooltip>
    );
}

export { Tooltip, TooltipTrigger };
