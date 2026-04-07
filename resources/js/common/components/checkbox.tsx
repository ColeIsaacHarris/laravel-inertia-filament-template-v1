import { CheckIcon } from 'lucide-react';
import {
    Checkbox as AriaCheckbox,
    type CheckboxProps as AriaCheckboxProps,
    type CheckboxRenderProps,
    composeRenderProps,
} from 'react-aria-components';
import { tv } from 'tailwind-variants';

import { focusRing } from '@/common/helpers/compose';

const checkboxStyles = tv({
    extend: focusRing,
    base: 'size-4 shrink-0 rounded-[4px] border border-input shadow-xs transition-shadow cursor-default',
    variants: {
        isSelected: {
            true: 'border-primary bg-primary text-primary-foreground',
        },
        isInvalid: {
            true: 'border-destructive ring-destructive/20 dark:ring-destructive/40',
        },
        isDisabled: {
            true: 'cursor-not-allowed opacity-50',
        },
    },
});

const checkboxGroupStyles = tv({
    base: 'group flex items-center gap-2 text-sm',
    variants: {
        isDisabled: {
            true: 'opacity-50',
        },
    },
});

interface CheckboxProps extends AriaCheckboxProps {
    label?: string;
}

function Checkbox({ label, children, ...props }: CheckboxProps) {
    const content = children ?? label;

    return (
        <AriaCheckbox
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    checkboxGroupStyles({ ...renderProps, className }),
            )}
        >
            {({
                isSelected,
                isIndeterminate,
                ...renderProps
            }: CheckboxRenderProps) => (
                <>
                    <div
                        className={checkboxStyles({
                            isSelected: isSelected || isIndeterminate,
                            isInvalid: renderProps.isInvalid,
                            isDisabled: renderProps.isDisabled,
                            isFocusVisible: renderProps.isFocusVisible,
                        })}
                    >
                        {(isSelected || isIndeterminate) && (
                            <CheckIcon className="m-auto size-3.5" />
                        )}
                    </div>
                    {typeof content === 'string' ? (
                        <span className="select-none">{content}</span>
                    ) : typeof content === 'function' ? (
                        content({
                            isSelected,
                            isIndeterminate,
                            ...renderProps,
                            defaultChildren: null,
                        })
                    ) : (
                        content
                    )}
                </>
            )}
        </AriaCheckbox>
    );
}

export { Checkbox, type CheckboxProps };
