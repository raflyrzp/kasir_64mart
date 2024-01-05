$(document).ready(function () {
    function downloadCSV(tableSelector, filename, columnsToExclude) {
        var table = $(tableSelector);

        var headers = [];
        var headerRow = table.find("thead tr");
        headerRow.find("th").each(function () {
            var headerText = $(this).text().trim();
            if (!columnsToExclude.includes(headerText)) {
                headers.push(headerText);
            }
        });
        var csv = [headers.join(",")].join("\n");

        var rows = table.find("tbody tr");

        rows.each(function () {
            var rowData = [];
            var row = $(this);

            row.find("td").each(function () {
                var headerText = headerRow
                    .find("th")
                    .eq($(this).index())
                    .text()
                    .trim();
                if (!columnsToExclude.includes(headerText)) {
                    rowData.push($(this).text().trim());
                }
            });

            csv += rowData.join(",") + "\n";
        });

        var blob = new Blob([csv], {
            type: "text/csv",
        });

        if (window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveBlob(blob, filename);
        } else {
            var csvUrl = window.URL.createObjectURL(blob);

            var a = document.createElement("a");
            a.href = csvUrl;
            a.download = filename;

            a.style.display = "none";
            document.body.appendChild(a);
            a.click();

            document.body.removeChild(a);
            window.URL.revokeObjectURL(csvUrl);
        }
    }

    $("#print-button").on("click", function () {
        window.print();
    });

    $("#save-csv-button").on("click", function () {
        downloadCSV("#table1", "{{ $title }}.csv", ["Action"]);
    });

    $("#save-excel-button").on("click", function () {
        var title = "{{ $title }}.xlsx";
        var table = document.getElementById("table1");

        var data = [];
        var rows = table.getElementsByTagName("tr");
        var headers = Array.from(rows[0].querySelectorAll("th")).map((header) =>
            header.innerText.trim()
        );

        for (var i = 1; i < rows.length; i++) {
            var rowData = [];
            var cells = Array.from(rows[i].querySelectorAll("td"));

            for (var j = 0; j < cells.length; j++) {
                if (headers[j] !== "Action") {
                    rowData.push(cells[j].innerText.trim());
                }
            }

            if (rowData.length > 0) {
                data.push(rowData);
            }
        }

        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(
            [headers.filter((header) => header !== "Action")].concat(data)
        );

        XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        XLSX.writeFile(wb, title);
    });
});
