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

document.addEventListener('DOMContentLoaded', () => {
    const sortArea = document.querySelector('[data-menu-sort]');

    if (!sortArea) {
        return;
    }

    let draggedItem = null;

    sortArea.querySelectorAll('[data-menu-item-id]').forEach((item) => {
        item.addEventListener('dragstart', (event) => {
            draggedItem = item;
            item.classList.add('is-dragging');
            event.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragend', () => {
            item.classList.remove('is-dragging');
            draggedItem = null;
        });
    });

    sortArea.querySelectorAll('[data-menu-list]').forEach((list) => {
        list.addEventListener('dragover', (event) => {
            event.preventDefault();
            const afterElement = getDragAfterElement(list, event.clientY);

            if (!draggedItem || draggedItem.contains(list)) {
                return;
            }

            if (afterElement == null) {
                list.appendChild(draggedItem);
            } else {
                list.insertBefore(draggedItem, afterElement);
            }
        });
    });

    sortArea.querySelector('[data-menu-save-sort]')?.addEventListener('click', async () => {
        const message = sortArea.querySelector('[data-menu-sort-message]');
        const rootList = sortArea.querySelector(':scope > [data-menu-list]');

        if (!rootList) {
            return;
        }

        message.textContent = 'در حال ذخیره...';

        const response = await fetch(sortArea.dataset.sortUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': sortArea.dataset.csrf,
            },
            body: JSON.stringify({ items: serializeMenuList(rootList) }),
        });

        message.textContent = response.ok ? 'ترتیب ذخیره شد.' : 'ذخیره ترتیب با خطا مواجه شد.';
    });
});

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll(':scope > [data-menu-item-id]:not(.is-dragging)')];

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;

        if (offset < 0 && offset > closest.offset) {
            return { offset, element: child };
        }

        return closest;
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function serializeMenuList(list) {
    return [...list.querySelectorAll(':scope > [data-menu-item-id]')].map((item) => {
        const childList = item.querySelector(':scope > [data-menu-list]');

        return {
            id: Number(item.dataset.menuItemId),
            children: childList ? serializeMenuList(childList) : [],
        };
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const jalaliInputs = document.querySelectorAll('[data-jalali-datepicker]');

    jalaliInputs.forEach((input) => {
        const dateOnly = input.hasAttribute('data-jalali-date-only');
        input.setAttribute('dir', 'ltr');
        input.setAttribute('inputmode', 'numeric');
        input.setAttribute('placeholder', input.getAttribute('placeholder') || (dateOnly ? '1403/01/15' : '1403/01/15 10:30'));
        input.classList.add('jalali-date-input');
    });

    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.persianDatepicker) {
        return;
    }

    window.jQuery('[data-jalali-datepicker]').each(function initializeJalaliDatepicker() {
        const input = window.jQuery(this);
        const dateOnly = this.hasAttribute('data-jalali-date-only');

        input.persianDatepicker({
            autoClose: true,
            calendar: {
                persian: {
                    locale: 'fa',
                    showHint: true,
                },
            },
            format: dateOnly ? 'YYYY/MM/DD' : 'YYYY/MM/DD HH:mm',
            initialValue: false,
            observer: true,
            timePicker: {
                enabled: !dateOnly,
                meridiem: {
                    enabled: false,
                },
            },
            toolbox: {
                calendarSwitch: {
                    enabled: false,
                },
            },
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const deleteModalElement = document.getElementById('adminDeleteModal');

    if (!deleteModalElement || !window.bootstrap) {
        return;
    }

    const deleteModal = new window.bootstrap.Modal(deleteModalElement);
    const confirmButton = deleteModalElement.querySelector('[data-admin-delete-confirm]');
    const messageElement = deleteModalElement.querySelector('[data-admin-delete-message]');
    let pendingDeleteForm = null;

    document.querySelectorAll('form').forEach((form) => {
        const methodInput = form.querySelector('input[name="_method"]');
        const isDeleteForm = methodInput && methodInput.value.toUpperCase() === 'DELETE';

        if (!isDeleteForm) {
            return;
        }

        form.setAttribute('data-admin-delete-form', 'true');

        form.addEventListener('submit', (event) => {
            if (form.dataset.adminDeleteConfirmed === 'true') {
                return;
            }

            event.preventDefault();
            pendingDeleteForm = form;

            if (messageElement) {
                const rowTitle = form.closest('tr')?.querySelector('strong')?.textContent?.trim();
                messageElement.textContent = rowTitle ? `مورد انتخاب‌شده: ${rowTitle}` : '';
            }

            deleteModal.show();
        });
    });

    confirmButton?.addEventListener('click', () => {
        if (!pendingDeleteForm) {
            return;
        }

        pendingDeleteForm.dataset.adminDeleteConfirmed = 'true';
        deleteModal.hide();
        pendingDeleteForm.requestSubmit();
    });

    deleteModalElement.addEventListener('hidden.bs.modal', () => {
        if (pendingDeleteForm?.dataset.adminDeleteConfirmed !== 'true') {
            pendingDeleteForm = null;
        }
    });
});
