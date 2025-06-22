document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("showAllBtn").addEventListener("click", function() {
        filter("all");
    });
    document.getElementById("showOngoingBtn").addEventListener("click", function() {
        filter("ongoing");
    });
    document.getElementById("showCompletedBtn").addEventListener("click", function() {
        filter("completed");
    });

    function filter(status) {
        var rows = document.querySelectorAll(".project-row");
        rows.forEach(function(row) {
            if (status === "all") {
                row.style.display = "";
            } else {
                if (row.getAttribute("data-status") === status) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    }
});
