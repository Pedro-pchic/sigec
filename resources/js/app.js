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
