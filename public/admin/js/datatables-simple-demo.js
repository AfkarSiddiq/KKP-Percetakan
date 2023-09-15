let minDate, maxDate;

// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    var selectedStatus = $('#status').val();

    let date = new Date(data[3]);
    // if on 4th column no date is found then it will be null
    if (date == "Invalid Date") {
        date = new Date(data[2]);
        console.log(date);
    }

    var statusColumn = data[8]; // Assuming "Status" is the 9th column
    statusColumn = statusColumn;

    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
    ) {
        if (selectedStatus === "" || statusColumn === selectedStatus) {
            return true;
        }
    }
    return false;
});

// Create date inputs
minDate = new DateTime("#minDate", {
    format: "MMMM Do YYYY",
});
maxDate = new DateTime("#maxDate", {
    format: "MMMM Do YYYY",
});

// // DataTables initialisation
let table = new DataTable('#datatablesSimple');

// Refilter the table
document.querySelectorAll("#minDate, #maxDate").forEach((el) => {
    el.addEventListener("change", () => table.draw());
});

// Refilter the table
document.querySelectorAll("#status").forEach((el) => {
    el.addEventListener("change", () => table.draw());
});