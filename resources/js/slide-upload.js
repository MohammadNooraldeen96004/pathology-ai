export default function registerSlideUpload(Alpine) {
    Alpine.data('slideUpload', () => ({
        fileName: '',
        fileSize: '',
        submitting: false,

        selectFile(event) {
            const file = event.target.files[0];

            if (!file) {
                this.fileName = '';
                this.fileSize = '';
                return;
            }

            this.fileName = file.name;

            const mb = file.size / 1024 / 1024;

            this.fileSize =
                mb >= 1024
                    ? (mb / 1024).toFixed(2) + ' GB'
                    : mb.toFixed(1) + ' MB';
        },
    }));
}