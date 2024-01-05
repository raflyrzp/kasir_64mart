$(document).ready(function () {
    $("#toggleSummary").click(function () {
        $("#rowTotalSummary").toggle();
        $("#rowTodaySummary").toggle();

        $(this).text(function (i, text) {
            return text === "All time" ? "Today" : "All time";
        });
    });
});
