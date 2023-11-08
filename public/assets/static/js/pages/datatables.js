let jquery_datatable = $("#table1").DataTable({
    responsive: true,
    buttons: ["copy", "excel", "pdf", "print"],
});
let customized_datatable = $("#table2").DataTable({
    responsive: true,
    pagingType: "simple",
    dom:
        "<'row'<'col-3'l><'col-9'f>>" +
        "<'row dt-row'<'col-sm-12'tr>>" +
        "<'row'<'col-4'i><'col-8'p>>",
    language: {
        info: "Page _PAGE_ of _PAGES_",
        lengthMenu: "_MENU_ ",
        search: "",
        searchPlaceholder: "Search..",
    },
    buttons: ["copy", "excel", "pdf", "print"],
});

const setTableColor = () => {
    document
        .querySelectorAll(".dataTables_paginate .pagination")
        .forEach((dt) => {
            dt.classList.add("pagination-primary");
        });
};
setTableColor();
jquery_datatable.on("draw", setTableColor);
