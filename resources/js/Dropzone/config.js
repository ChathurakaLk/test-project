Dropzone.options.dropzone = {
    paramName: "images[]",
    maxFilesize: 10,
    maxFiles: 5,
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Remove",
    clickable: true,

    dictMaxFilesExceeded:
        "You have exceeded the file limit. Only the first 5 images will be saved.",

    errorDisplayed: false,

    success: function (file, response) {
        const filePathInput = document.getElementById("images");
        let filePaths = filePathInput.value
            ? JSON.parse(filePathInput.value)
            : [];
        filePaths.push(response.file_paths);
        filePathInput.value = JSON.stringify(filePaths);
        $(filePathInput).trigger("change");
        this.options.errorDisplayed = false;
    },

    error: function (file, response) {
        if (!this.options.errorDisplayed) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: response.message || response,
                confirmButtonText: "OK",
            });
            this.options.errorDisplayed = true;
        }
    },

    queueComplete: function () {
        this.options.errorDisplayed = false;
    },

    removedfile: function (file) {
        const filePathInput = document.getElementById("images");
        let filePaths = filePathInput.value
            ? JSON.parse(filePathInput.value)
            : [];
        filePaths = filePaths.filter(
            (path) => path !== file.previewElement.getAttribute("data-path")
        );
        filePathInput.value = JSON.stringify(filePaths);
        $(filePathInput).trigger("change");
        file.previewElement.remove();
    },
};
