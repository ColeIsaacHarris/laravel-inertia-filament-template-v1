import {
    FieldError as AriaFieldError,
    Input as AriaInput,
    Label as AriaLabel,
    TextField as AriaTextField,
    composeRenderProps,
    Text,
    type TextFieldProps as AriaTextFieldProps,
    type LabelProps,
    type ValidationResult,
} from 'react-aria-components';
import { twMerge } from 'tailwind-merge';
import { tv } from 'tailwind-variants';

import {
    composeTailwindRenderProps,
    focusRing,
} from '@/common/helpers/compose';

const inputStyles = tv({
    extend: focusRing,
    base: 'flex h-9 w-full min-w-0 rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none selection:bg-primary selection:text-primary-foreground file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground md:text-sm',
    variants: {
        isFocused: {
            true: 'border-ring ring-[3px] ring-ring/50',
        },
        isInvalid: {
            true: 'border-destructive ring-destructive/20 dark:ring-destructive/40',
        },
        isDisabled: {
            true: 'pointer-events-none cursor-not-allowed opacity-50',
        },
    },
});

const labelStyles = tv({
    base: 'text-sm leading-none font-medium select-none',
    variants: {
        isDisabled: {
            true: 'pointer-events-none opacity-50',
        },
    },
});

interface TextFieldProps extends AriaTextFieldProps {
    label?: string;
    description?: string;
    errorMessage?: string | ((validation: ValidationResult) => string);
}

function TextField({
    label,
    description,
    errorMessage,
    ...props
}: TextFieldProps) {
    return (
        <AriaTextField
            {...props}
            className={composeTailwindRenderProps(
                props.className,
                'flex flex-col gap-1',
            )}
        >
            {label && <Label>{label}</Label>}
            <Input />
            {description && <Description>{description}</Description>}
            <FieldError>{errorMessage}</FieldError>
        </AriaTextField>
    );
}

function Label({ className, ...props }: LabelProps) {
    return (
        <AriaLabel
            {...props}
            className={twMerge(labelStyles(), className as string)}
        />
    );
}

function Input(props: React.ComponentProps<typeof AriaInput>) {
    return (
        <AriaInput
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    inputStyles({
                        isFocused: renderProps.isFocused,
                        isInvalid: renderProps.isInvalid,
                        isDisabled: renderProps.isDisabled,
                        isFocusVisible: renderProps.isFocusVisible,
                        className,
                    }),
            )}
        />
    );
}

function FieldError(props: React.ComponentProps<typeof AriaFieldError>) {
    return (
        <AriaFieldError
            {...props}
            className={composeTailwindRenderProps(
                props.className,
                'text-sm text-destructive',
            )}
        />
    );
}

function Description({
    className,
    ...props
}: Omit<React.ComponentProps<typeof Text>, 'slot'>) {
    return (
        <Text
            {...props}
            slot="description"
            className={twMerge('text-sm text-muted-foreground', className)}
        />
    );
}

export {
    Description,
    FieldError,
    Input,
    Label,
    TextField,
    type TextFieldProps,
};
