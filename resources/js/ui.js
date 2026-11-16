export default function registerUi(Alpine) {
    Alpine.data('appUi', () => ({
        flashVisible: true,

        confirmOpen: false,
        confirmMessage: '',
        pendingForm: null,

        init() {
            if (this.$refs.flash) {
                setTimeout(() => {
                    this.flashVisible = false;
                }, 4500);
            }
        },

        requestConfirmation(event, message = 'Are you sure you want to continue?') {
            event.preventDefault();

            this.pendingForm = event.currentTarget;
            this.confirmMessage = message;
            this.confirmOpen = true;
        },

        cancelConfirmation() {
            this.confirmOpen = false;
            this.confirmMessage = '';
            this.pendingForm = null;
        },

        confirmAction() {
            if (!this.pendingForm) {
                return;
            }

            const form = this.pendingForm;

            this.confirmOpen = false;
            this.pendingForm = null;

            form.submit();
        },
    }));
}