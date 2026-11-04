const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const PHONE_PATTERN = /^\+?[0-9 ().-]{6,25}$/;
const MAX_FILE_BYTES = 5 * 1024 * 1024;
const IGNORED = new Set(['_token', '_form', 'website']);

/**
 * Quote and application forms. Validates in the browser, sends the form to Laravel, and shows the success
 * message only once the server has confirmed (HTTP 201) that the request was stored and e-mailed.
 */
export default ({ messages, initialStatus, initialErrors, initialMessage }) => ({
    errors: { ...initialErrors },
    status: initialStatus,
    serverMessage: initialMessage,
    fileNames: {},

    fields() {
        return [...this.$refs.form.elements].filter((field) => field.name && !IGNORED.has(field.name));
    },

    fieldError(field) {
        if (field.type === 'file') {
            const file = field.files[0];
            if (!file) return field.required ? messages.required : undefined;
            const allowed = (field.dataset.extensions || '').split(',').filter(Boolean);
            if (allowed.length && !allowed.includes(file.name.split('.').pop().toLowerCase())) return field.dataset.invalidMessage || messages.invalidFile;
            if (file.size > MAX_FILE_BYTES) return messages.fileTooLarge;
            return undefined;
        }
        const value = field.value.trim();
        if (field.required && value === '') return messages.required;
        if (value === '') return undefined;
        if (field.type === 'email' && !EMAIL_PATTERN.test(value)) return messages.invalidEmail;
        if (field.type === 'tel' && !PHONE_PATTERN.test(value)) return messages.invalidPhone;
        return undefined;
    },

    validate() {
        const errors = {};
        for (const field of this.fields()) {
            const error = this.fieldError(field);
            if (error) errors[field.name] = error;
        }
        this.errors = errors;
        this.focusFirstError();
        return Object.keys(errors).length === 0;
    },

    focusFirstError() {
        const first = this.fields().find((field) => this.errors[field.name]);
        first?.focus();
    },

    // Once a field shows an error, re-check it as the visitor corrects it.
    recheck(event) {
        const field = event.target;
        if (!field.name || !this.errors[field.name]) return;
        this.errors = { ...this.errors, [field.name]: this.fieldError(field) };
    },

    async submit() {
        if (this.status === 'submitting' || !this.validate()) return;
        this.status = 'submitting';
        this.serverMessage = '';

        let response;
        try {
            response = await fetch(this.$refs.form.action, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: new FormData(this.$refs.form),
            });
        } catch {
            this.fail(messages.failure);
            return;
        }

        if (response.status === 201) {
            this.status = 'success';
            this.$nextTick(() => this.$el.scrollIntoView({ block: 'nearest' }));
            return;
        }

        const data = await response.json().catch(() => ({}));
        if (response.status === 422 && data.errors) {
            this.errors = Object.fromEntries(Object.entries(data.errors).map(([name, list]) => [name, list[0]]));
            this.status = 'idle';
            this.$nextTick(() => this.focusFirstError());
            return;
        }
        this.fail(response.status === 429 ? messages.tooMany : data.message || messages.failure);
    },

    fail(message) {
        this.serverMessage = message;
        this.status = 'error';
    },

    startOver() {
        this.$refs.form.reset();
        this.errors = {};
        this.fileNames = {};
        this.serverMessage = '';
        this.status = 'idle';
    },
});
