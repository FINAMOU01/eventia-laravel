const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const FIELDS = ['name', 'company', 'email', 'phone', 'date', 'location', 'eventType', 'need'];

/** Port of components/site/contact-form.tsx and lib/quote-request.ts. */
export default ({ required, messages, email, to }) => ({
    errors: {},
    status: 'idle',

    fieldError(name, value) {
        const trimmed = value.trim();
        if (required.includes(name) && trimmed === '') return messages.required;
        if (name === 'email' && trimmed !== '' && !EMAIL_PATTERN.test(trimmed)) return messages.invalidEmail;
        return undefined;
    },

    readRequest() {
        const data = new FormData(this.$refs.form);
        return Object.fromEntries(FIELDS.map((name) => [name, String(data.get(name) ?? '')]));
    },

    validate() {
        const request = this.readRequest();
        const errors = {};
        for (const name of FIELDS) {
            const error = this.fieldError(name, request[name]);
            if (error) errors[name] = error;
        }
        this.errors = errors;

        const firstInvalid = FIELDS.find((name) => errors[name]);
        if (firstInvalid) this.$refs.form.querySelector(`[name="${firstInvalid}"]`)?.focus();
        return firstInvalid ? null : request;
    },

    // Once a field shows an error, re-check it as the visitor corrects it.
    recheck(event) {
        const field = event.target;
        if (!this.errors[field.name]) return;
        this.errors = { ...this.errors, [field.name]: this.fieldError(field.name, field.value) };
    },

    async submit() {
        const request = this.validate();
        if (!request) return;

        this.status = 'submitting';
        try {
            this.send(request);
            this.status = 'success';
        } catch {
            this.status = 'idle';
        }
    },

    /**
     * Single integration point for quote requests. No backend is configured yet, so this opens the visitor's
     * e-mail client with a pre-filled message, exactly like the Next.js site.
     */
    send(request) {
        const summary = FIELDS.filter((key) => request[key].trim() !== '')
            .map((key) => `${email.labels[key]} : ${request[key].trim()}`)
            .join('\n');
        const eventType = request.eventType.trim();
        const subject = `${email.subject}${eventType ? ` — ${eventType}` : ''}`;
        const body = `${email.intro}\n\n${summary}\n`;
        window.location.href = `mailto:${to}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    },

    startOver() {
        this.errors = {};
        this.status = 'idle';
        this.$refs.form.reset();
    },
});
