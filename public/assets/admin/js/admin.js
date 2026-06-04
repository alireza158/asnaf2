document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggles = document.querySelectorAll('[data-admin-sidebar-toggle]');
    const sidebarClosers = document.querySelectorAll('[data-admin-sidebar-close]');

    const openSidebar = () => document.body.classList.add('admin-sidebar-open');
    const closeSidebar = () => document.body.classList.remove('admin-sidebar-open');

    sidebarToggles.forEach((button) => {
        button.addEventListener('click', () => {
            if (document.body.classList.contains('admin-sidebar-open')) {
                closeSidebar();
                return;
            }

            openSidebar();
        });
    });

    sidebarClosers.forEach((element) => {
        element.addEventListener('click', closeSidebar);
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });
});
