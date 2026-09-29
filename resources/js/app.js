const sidebar = document.querySelector('[data-admin-sidebar]');
const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
const sidebarOpenButton = document.querySelector('[data-sidebar-open]');
const sidebarCloseButton = document.querySelector('[data-sidebar-close]');

if (sidebar && sidebarOverlay && sidebarOpenButton && sidebarCloseButton) {
    const setSidebarOpen = (isOpen) => {
        sidebar.classList.toggle('-translate-x-full', !isOpen);
        sidebarOverlay.classList.toggle('pointer-events-none', !isOpen);
        sidebarOverlay.classList.toggle('opacity-0', !isOpen);
        sidebarOpenButton.setAttribute('aria-expanded', String(isOpen));
        document.body.classList.toggle('overflow-hidden', isOpen);

        if (isOpen) {
            sidebarCloseButton.focus();
        }
    };

    sidebarOpenButton.addEventListener('click', () => setSidebarOpen(true));
    sidebarCloseButton.addEventListener('click', () => setSidebarOpen(false));
    sidebarOverlay.addEventListener('click', () => setSidebarOpen(false));

    sidebar.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => setSidebarOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && sidebarOpenButton.getAttribute('aria-expanded') === 'true') {
            setSidebarOpen(false);
            sidebarOpenButton.focus();
        }
    });

    window.addEventListener('resize', () => {
        if (window.matchMedia('(min-width: 64rem)').matches) {
            setSidebarOpen(false);
        }
    });
}

document.querySelectorAll('[data-purchase-form]').forEach((form) => {
    const lines = form.querySelector('[data-purchase-lines]');
    const template = form.querySelector('[data-purchase-line-template]');
    const addButton = form.querySelector('[data-add-purchase-line]');
    const totalOutput = form.querySelector('[data-purchase-total]');
    const money = new Intl.NumberFormat('es-GT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    const purchaseLines = () => [...lines.querySelectorAll('[data-purchase-line]')];

    const updateNames = () => {
        purchaseLines().forEach((line, index) => {
            line.querySelectorAll('[data-purchase-field]').forEach((field) => {
                const fieldName = field.dataset.purchaseField;
                const fieldId = 'detail-' + index + '-' + fieldName.replace(/_/g, '-');

                field.name = 'details[' + index + '][' + fieldName + ']';
                field.id = fieldId;
                line.querySelector('[data-purchase-label="' + fieldName + '"]').htmlFor = fieldId;
            });
        });
    };

    const updateTotals = () => {
        let total = 0;

        purchaseLines().forEach((line) => {
            const quantity = Number(line.querySelector('[data-purchase-field="quantity"]').value);
            const unitCost = Number(line.querySelector('[data-purchase-field="unit_cost"]').value);
            const subtotal = Number.isFinite(quantity * unitCost) ? quantity * unitCost : 0;

            line.querySelector('[data-purchase-subtotal]').textContent = money.format(subtotal);
            total += subtotal;
        });

        totalOutput.textContent = money.format(total);
    };

    const addLine = () => {
        lines.append(template.content.cloneNode(true));
        updateNames();
        updateTotals();
    };

    addButton.addEventListener('click', addLine);

    lines.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-purchase-line]');

        if (!removeButton) {
            return;
        }

        const line = removeButton.closest('[data-purchase-line]');

        if (purchaseLines().length === 1) {
            line.querySelectorAll('[data-purchase-field]').forEach((field) => {
                field.value = '';
            });
        } else {
            line.remove();
        }

        updateNames();
        updateTotals();
    });

    lines.addEventListener('input', updateTotals);
    lines.addEventListener('change', updateTotals);
    updateNames();
    updateTotals();
});

document.querySelectorAll('[data-quote-form]').forEach((form) => {
    const lines = form.querySelector('[data-quote-lines]');
    const template = form.querySelector('[data-quote-line-template]');
    const addButton = form.querySelector('[data-add-quote-line]');
    const totalOutput = form.querySelector('[data-quote-total]');
    const money = new Intl.NumberFormat('es-GT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    const quoteLines = () => [...lines.querySelectorAll('[data-quote-line]')];

    const updateNames = () => {
        quoteLines().forEach((line, index) => {
            line.querySelectorAll('[data-quote-field]').forEach((field) => {
                const fieldName = field.dataset.quoteField;
                const fieldId = 'quote-detail-' + index + '-' + fieldName.replace(/_/g, '-');

                field.name = 'details[' + index + '][' + fieldName + ']';
                field.id = fieldId;
                line.querySelector('[data-quote-label="' + fieldName + '"]').htmlFor = fieldId;
            });
        });
    };

    const updateTotals = () => {
        let total = 0;

        quoteLines().forEach((line) => {
            const quantity = Number(line.querySelector('[data-quote-field="quantity"]').value);
            const unitPrice = Number(line.querySelector('[data-quote-field="unit_price"]').value);
            const subtotal = Number.isFinite(quantity * unitPrice) ? quantity * unitPrice : 0;

            line.querySelector('[data-quote-subtotal]').textContent = 'Q ' + money.format(subtotal);
            total += subtotal;
        });

        totalOutput.textContent = 'Q ' + money.format(total);
    };

    const addLine = () => {
        lines.append(template.content.cloneNode(true));
        updateNames();
        updateTotals();
    };

    addButton.addEventListener('click', addLine);

    lines.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-quote-line]');

        if (!removeButton) {
            return;
        }

        const line = removeButton.closest('[data-quote-line]');

        if (quoteLines().length === 1) {
            line.querySelectorAll('[data-quote-field]').forEach((field) => {
                field.value = field.dataset.quoteField === 'quantity' ? '1' : '';
            });
        } else {
            line.remove();
        }

        updateNames();
        updateTotals();
    });

    lines.addEventListener('change', (event) => {
        const productField = event.target.closest('[data-quote-field="product_id"]');

        if (productField) {
            const unitPriceField = productField.closest('[data-quote-line]').querySelector('[data-quote-field="unit_price"]');
            const selectedOption = productField.selectedOptions[0];

            unitPriceField.value = selectedOption.dataset.price ?? '';
        }

        updateTotals();
    });

    lines.addEventListener('input', updateTotals);
    updateNames();
    updateTotals();
});

document.querySelectorAll('[data-order-form]').forEach((form) => {
    const lines = form.querySelector('[data-order-lines]');
    const template = form.querySelector('[data-order-line-template]');
    const addButton = form.querySelector('[data-add-order-line]');
    const totalOutput = form.querySelector('[data-order-total]');
    const money = new Intl.NumberFormat('es-GT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    const orderLines = () => [...lines.querySelectorAll('[data-order-line]')];

    const updateNames = () => {
        orderLines().forEach((line, index) => {
            line.querySelectorAll('[data-order-field]').forEach((field) => {
                const fieldName = field.dataset.orderField;
                const fieldId = 'order-detail-' + index + '-' + fieldName.replace(/_/g, '-');

                field.name = 'details[' + index + '][' + fieldName + ']';
                field.id = fieldId;
                line.querySelector('[data-order-label="' + fieldName + '"]').htmlFor = fieldId;
            });
        });
    };

    const updateTotals = () => {
        let total = 0;

        orderLines().forEach((line) => {
            const quantity = Number(line.querySelector('[data-order-field="quantity"]').value);
            const unitPrice = Number(line.querySelector('[data-order-field="unit_price"]').value);
            const subtotal = Number.isFinite(quantity * unitPrice) ? quantity * unitPrice : 0;

            line.querySelector('[data-order-subtotal]').textContent = 'Q ' + money.format(subtotal);
            total += subtotal;
        });

        totalOutput.textContent = 'Q ' + money.format(total);
    };

    addButton.addEventListener('click', () => {
        lines.append(template.content.cloneNode(true));
        updateNames();
        updateTotals();
    });

    lines.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-order-line]');

        if (!removeButton) {
            return;
        }

        const line = removeButton.closest('[data-order-line]');

        if (orderLines().length === 1) {
            line.querySelectorAll('[data-order-field]').forEach((field) => {
                field.value = field.dataset.orderField === 'quantity' ? '1' : '';
            });
        } else {
            line.remove();
        }

        updateNames();
        updateTotals();
    });

    lines.addEventListener('change', (event) => {
        const productField = event.target.closest('[data-order-field="product_id"]');

        if (productField) {
            const unitPriceField = productField.closest('[data-order-line]').querySelector('[data-order-field="unit_price"]');
            const selectedOption = productField.selectedOptions[0];

            unitPriceField.value = selectedOption.dataset.price ?? '';
        }

        updateTotals();
    });

    lines.addEventListener('input', updateTotals);
    updateNames();
    updateTotals();
});
