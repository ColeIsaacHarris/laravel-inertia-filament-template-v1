import {
    Menu,
    MenuItem,
    MenuLabel,
    MenuSection,
    MenuSeparator,
} from '@/common/components/menu';
import { toUrl } from '@/common/helpers/utils';
import type { User } from '@/common/types/auth';
import { UserInfo } from '@/modules/app-shell/components/user-info';
import { useMobileNavigation } from '@/modules/app-shell/hooks/use-mobile-navigation';
import { logout } from '@/routes';
import { edit } from '@/routes/profile';
import { router } from '@inertiajs/react';
import { LogOut, Settings } from 'lucide-react';

type Props = {
    user: User;
};

export function UserMenuContent({ user }: Props) {
    const cleanup = useMobileNavigation();

    const handleLogout = () => {
        cleanup();
        router.flushAll();
    };

    return (
        <Menu>
            <MenuSection>
                <MenuLabel className="p-0 font-normal">
                    <div className="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                        <UserInfo user={user} showEmail={true} />
                    </div>
                </MenuLabel>
            </MenuSection>
            <MenuSeparator />
            <MenuSection>
                {/* <MenuItem
                    onAction={() => {
                        cleanup();
                        router.visit(edit());
                    }}
                >
                    <Settings className="mr-2" />
                    Settings
                </MenuItem> */}
                <MenuItem href={toUrl(edit())} onAction={() => cleanup()}>
                    <Settings className="mr-2" />
                    Settings
                </MenuItem>
            </MenuSection>
            <MenuSeparator />
            <MenuItem
                onAction={() => {
                    handleLogout();
                    router.post(logout());
                }}
                data-test="logout-button"
            >
                <LogOut className="mr-2" />
                Log out
            </MenuItem>
        </Menu>
    );
}
