document.addEventListener('DOMContentLoaded', () => {
    const rangeMin = document.getElementById('range-min');
    const rangeMax = document.getElementById('range-max');
    const inputMin = document.getElementById('min-val');
    const inputMax = document.getElementById('max-val');
    const progress = document.querySelector('.slider_progress');
    const priceGap = 10;

    function updateProgress() {
        if (!progress) return;
        const minValue = parseInt(rangeMin.value);
        const maxValue = parseInt(rangeMax.value);
        const minPercent = (minValue / rangeMin.max) * 100;
        const maxPercent = (maxValue / rangeMax.max) * 100;
        progress.style.left = minPercent + '%';
        progress.style.right = (100 - maxPercent) + '%';
    }

    if (rangeMin) {
        rangeMin.addEventListener('input', (e) => {
            let minValue = parseInt(e.target.value);
            let maxValue = parseInt(rangeMax.value);
            if (maxValue - minValue < priceGap) {
                minValue = maxValue - priceGap;
                e.target.value = minValue;
            }
            inputMin.value = minValue;
            updateProgress();
        });
    }

    if (rangeMax) {
        rangeMax.addEventListener('input', (e) => {
            let maxValue = parseInt(e.target.value);
            let minValue = parseInt(rangeMin.value);
            if (maxValue - minValue < priceGap) {
                maxValue = minValue + priceGap;
                e.target.value = maxValue;
            }
            inputMax.value = maxValue;
            updateProgress();
        });
    }

    if (inputMin) {
        inputMin.addEventListener('input', (e) => {
            let minValue = parseInt(e.target.value);
            if (minValue >= 0 && minValue <= parseInt(rangeMax.value) - priceGap) {
                rangeMin.value = minValue;
                updateProgress();
            }
        });
    }

    if (inputMax) {
        inputMax.addEventListener('input', (e) => {
            let maxValue = parseInt(e.target.value);
            if (maxValue <= 150 && maxValue >= parseInt(rangeMin.value) + priceGap) {
                rangeMax.value = maxValue;
                updateProgress();
            }
        });
    }

    if (progress) {
        updateProgress();
    }

    const form = document.querySelector('.custom-form');
    const select = document.getElementById('framework-select');
    const fullNameInput = document.getElementById('full-name');
    const ageInput = document.getElementById('age');
    const requiredCheckbox = document.getElementById('required-check');
    const optionalCheckbox = document.getElementById('optional-check');

    const modalOverlay = document.getElementById('modal-overlay');
    const modalContent = document.getElementById('modal-content');
    const closeModal = document.getElementById('close-modal');

    const fullNameError = document.getElementById('full-name-error');
    const ageError = document.getElementById('age-error');
    const requiredCheckboxError = document.getElementById('required-check-error');

    if (ageInput) {
        ageInput.addEventListener('input', function (e) {
            this.value = this.value.replace(/\D/g, '');
        });
    }

    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            let isValid = true;

            fullNameInput.classList.remove('invalid');
            ageInput.classList.remove('invalid');
            requiredCheckbox.nextElementSibling.classList.remove('invalid');
            fullNameError.textContent = '';
            ageError.textContent = '';
            requiredCheckboxError.textContent = '';

            const fullNameValue = fullNameInput.value.trim();
            const nameParts = fullNameValue.split(' ').filter(part => part.length > 0);

            if (/\d/.test(fullNameValue)) {
                isValid = false;
                fullNameInput.classList.add('invalid');
                fullNameError.textContent = 'ФИО не должно содержать цифры.';
            } else if (nameParts.length !== 3) {
                isValid = false;
                fullNameInput.classList.add('invalid');
                fullNameError.textContent = 'Введите фамилию, имя и отчество.';
            } else if (nameParts.some(part => part.length < 2)) {
                isValid = false;
                fullNameInput.classList.add('invalid');
                fullNameError.textContent = 'Каждая часть ФИО должна содержать не менее 2 символов.';
            }

            if (ageInput.value.trim() === '') {
                isValid = false;
                ageInput.classList.add('invalid');
                ageError.textContent = 'Поле возраста не должно быть пустым.';
            }

            if (!requiredCheckbox.checked) {
                isValid = false;
                requiredCheckbox.nextElementSibling.classList.add('invalid');
                requiredCheckboxError.textContent = 'Это поле обязательно для заполнения.';
            }

            if (isValid) {
                const rangeFromValue = inputMin.value;
                const rangeToValue = inputMax.value;
                const selectValue = select.value || 'Не выбрано';
                const radioElement = document.querySelector('input[name="language"]:checked');
                const radioValue = radioElement ? radioElement.value : 'Не выбрано';
                const ageValue = parseInt(ageInput.value);

                let selectedCheckboxes = [];
                if (requiredCheckbox.checked) {
                    selectedCheckboxes.push(requiredCheckbox.nextElementSibling.textContent);
                }
                if (optionalCheckbox.checked) {
                    selectedCheckboxes.push(optionalCheckbox.nextElementSibling.textContent);
                }
                const checkboxesValue = selectedCheckboxes.length > 0 ? selectedCheckboxes.join(', ') : 'Не выбрано';

                const formData = new FormData();
                formData.append('range_from', rangeFromValue);
                formData.append('range_to', rangeToValue);
                formData.append('select', selectValue);
                formData.append('radio', radioValue);
                formData.append('full_name', fullNameValue);
                formData.append('age', ageValue);
                formData.append('checkboxes', checkboxesValue);

                fetch('/local/templates/test/handler.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Сетевой ответ был не в порядке: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.data) {
                            const result = data.data;
                            modalContent.innerHTML = `
                            <p><strong>${result.message}</strong></p>
                            <hr>
                            <p><strong>Диапазон:</strong> ${result.range}</p>
                            <p><strong>Select:</strong> ${result.select}</p>
                            <p><strong>Radio:</strong> ${result.radio}</p>
                            <p><strong>ФИО:</strong> ${result.fullName}</p>
                            <p><strong>Возраст:</strong> ${result.age}</p>
                            <p><strong>Выбранные checkbox:</strong> ${result.checkboxes}</p>
                        `;
                        } else {
                            modalContent.innerHTML = `<p>${data.message || 'Произошла неизвестная ошибка.'}</p>`;
                        }
                        modalOverlay.style.display = 'flex';
                    })
                    .catch(error => {
                        console.error('Ошибка отправки формы:', error);
                        modalContent.innerHTML = `<p>Произошла критическая ошибка при отправке заявки. Откройте консоль разработчика (F12) для просмотра деталей.</p>`;
                        modalOverlay.style.display = 'flex';
                    });
            }
        });
    }

    function hideModal() {
        modalOverlay.style.display = 'none';
    }

    if (closeModal) {
        closeModal.addEventListener('click', hideModal);
    }

    if (modalOverlay) {
        modalOverlay.addEventListener('click', (event) => {
            if (event.target === modalOverlay) {
                hideModal();
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modalOverlay.style.display === 'flex') {
            hideModal();
        }
    });

    const copyrightSpan = document.getElementById('copyright-info');
    if (copyrightSpan) {
        const currentYear = new Date().getFullYear();
        const birthYear = "год рожденья-текущий год";
        const fullName = "ФИО";
        copyrightSpan.textContent = `© ${fullName}, ${birthYear}-${currentYear}`;
    }
});