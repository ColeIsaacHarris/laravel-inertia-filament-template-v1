import { ChevronDownIcon } from 'lucide-react';
import {
    Select as AriaSelect,
    type SelectProps as AriaSelectProps,
    Button,
    ListBox,
    ListBoxItem,
    type ListBoxItemProps,
    Popover,
    SelectValue,
    type ValidationResult,
    composeRenderProps,
} from 'react-aria-components';
import { tv } from 'tailwind-variants';

import { FieldError, Label } from '@/common/components/text-field';
import {
    composeTailwindRenderProps,
    focusRing,
} from '@/common/helpers/compose';

const selectTriggerStyles = tv({
    extend: focusRing,
    base: 'flex h-9 w-full items-center justify-between rounded-md border border-input bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] cursor-default md:text-sm',
    variants: {
        isDisabled: {
            true: 'pointer-events-none opacity-50',
        },
    },
});

const listBoxItemStyles = tv({
    base: 'relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors',
    variants: {
        isFocused: {
            true: 'bg-accent text-accent-foreground',
        },
        isSelected: {
            true: 'font-medium',
        },
        isDisabled: {
            true: 'pointer-events-none opacity-50',
        },
    },
});

interface SelectProps<T extends object> extends Omit<
    AriaSelectProps<T>,
    'children'
> {
    label?: string;
    description?: string;
    errorMessage?: string | ((validation: ValidationResult) => string);
    items?: Iterable<T>;
    children: React.ReactNode | ((item: T) => React.ReactNode);
}

function Select<T extends object>({
    label,
    errorMessage,
    children,
    items,
    ...props
}: SelectProps<T>) {
    return (
        <AriaSelect
            {...props}
            className={composeTailwindRenderProps(
                props.className,
                'flex flex-col gap-1',
            )}
        >
            {label && <Label>{label}</Label>}
            <Button
                className={composeRenderProps('', (className, renderProps) =>
                    selectTriggerStyles({ ...renderProps, className }),
                )}
            >
                <SelectValue className="truncate placeholder:text-muted-foreground" />
                <ChevronDownIcon className="size-4 opacity-50" />
            </Button>
            <FieldError>{errorMessage}</FieldError>
            <Popover className="w-(--trigger-width) rounded-md border bg-popover p-1 text-popover-foreground shadow-md">
                <ListBox
                    items={items}
                    className="max-h-60 overflow-auto outline-none"
                >
                    {children}
                </ListBox>
            </Popover>
        </AriaSelect>
    );
}

function SelectItem(props: ListBoxItemProps) {
    return (
        <ListBoxItem
            {...props}
            className={composeRenderProps(
                props.className,
                (className, renderProps) =>
                    listBoxItemStyles({ ...renderProps, className }),
            )}
        />
    );
}

export { Select, SelectItem };
