document.addEventListener("DOMContentLoaded", function () {
    var titleElement = document.querySelector(
        ".p-calendar .p-datepicker-title"
    );

    if (titleElement) {
        var titleText = titleElement.textContent.trim();
        var month = titleText.substring(0, titleText.length - 4);
        var year = titleText.substring(titleText.length - 4);
        var newTextContent = month + " " + year;
        titleElement.textContent = newTextContent;
    }
});
