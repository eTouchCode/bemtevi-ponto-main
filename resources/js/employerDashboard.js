import Choices from "choices.js";

document.addEventListener("DOMContentLoaded", async (event) => {
    populateAbsenceStats();
});

const employeeDashboardSelect = document.getElementById(
    "dashboardEmployeeSearch"
);

if (employeeDashboardSelect) {
    const dashboardEmployeeSearch = new Choices(employeeDashboardSelect, {
        allowHTML: true,
        searchEnabled: true,
        searchPlaceholderValue: "Pesquisar",
        searchFloor: 4,
        renderChoiceLimit: 5,
        noResultsText: "",
        noChoicesText: "",
        classNames: {
            containerInner: "choices__inner text-dark",
            item: "choices__item",
            highlightedState: "text-dark",
            selectedState: "text-dark",
        },
    });

    employeeDashboardSelect.addEventListener("change", async (e) => {
        const employeeId = e.target.value;

        const statCards = document.getElementById("statCardsContainer");
        const chartContainer = document.getElementById(
            "employeeChartContainer"
        );
        statCards.style.display = "none";
        statCards.classList.remove("animate__animated", "animate__fadeIn");
        chartContainer.classList.remove("animate__animated", "animate__fadeIn");
        chartContainer.style.display = "none";

        if (!employeeId) {
            return;
        }
        statCards.style.display = "block";
        statCards.classList.add("animate__animated", "animate__fadeIn");
        chartContainer.style.display = "block";
        chartContainer.classList.add("animate__animated", "animate__fadeIn");

        const attendanceTable = document.querySelector(
            "#dashboardEmployeeAttendance tbody"
        );
        attendanceTable.innerHTML = "";

        const response = await Promise.all([
            fetch(`/dashboard/employeeStats/attendance/${employeeId}`).then(
                (response) => response.json()
            ),
            fetch(`/dashboard/employeeStats/${employeeId}`).then((response) =>
                response.json()
            ),
        ]).then((values) => {
            return values;
        });

        let employeeAttendance = await response[0];
        let employeeStats = await response[1];

        console.log(employeeStats, employeeAttendance);
        if (employeeStats) {
            populateEmployeeStats(employeeStats);
        }

        if (employeeAttendance) {
            populateEmployeeAttendance(employeeAttendance);
        }
    });
}

document.querySelectorAll(".simplePagination").forEach((element) => {
    element.addEventListener("click", async (e) => {
        e.preventDefault();
        if (e.target.classList.contains("page-link")) {
            const response = await fetch(e.target.href);
            document.getElementById("attendancePagination").innerHTML = "";

            const responseData = await response.json();

            console.log(responseData);

            populateEmployeeAttendance(responseData);
        }
    });
});

function populateEmployeeStats(employeeStats) {
    document.getElementById("contractStart").innerText =
        employeeStats.contract_start.date;
    document.getElementById("contractStartDiff").innerText =
        employeeStats.contract_start.diff;
    document.getElementById("hourBankExtra").innerText =
        employeeStats.hour_bank.extraHours;
    document.getElementById("nextVacationDate").innerText =
        employeeStats.next_vacation.date;
    document.getElementById("nextVacationDiff").innerText =
        employeeStats.next_vacation.diff;
    document.getElementById("absentDays").innerText =
        employeeStats.absent_days.amount;
    document.getElementById(
        "lastAbsence"
    ).innerText = `${employeeStats.absent_days.last_absence} ${employeeStats.absent_days.last_absencediff}`;
    document.getElementById("lastPayment").innerText =
        employeeStats.last_payment.salary;
    document.getElementById("lastPaymentDate").innerText =
        employeeStats.last_payment.date;
    document.getElementById("breakDaysAmount").innerText =
        employeeStats.break_days.amount;
    document.getElementById(
        "lastBreak"
    ).innerText = `${employeeStats.break_days.last_break} (${employeeStats.break_days.last_breakdiff})`;
}

function populateEmployeeAttendance(employeeAttendance) {
    const attendanceTable = document.querySelector(
        "#dashboardEmployeeAttendance tbody"
    );

    if (!employeeAttendance) {
        return;
    }

    attendanceTable.innerHTML = "";

    employeeAttendance.data.forEach((data, index) => {
        const newRow = attendanceTable.insertRow(index);
        Object.keys(data).forEach((column) => {
            const newColumn = document.createElement("td");
            newColumn.classList.add("text-center");
            newColumn.innerHTML = data[column];
            newRow.appendChild(newColumn);
        });
    });

    document.getElementById("attendancePagination").innerHTML =
        employeeAttendance.links;
}

async function populateAbsenceStats(date = "") {
    const request = await fetch(`/dashboard/employeeAbsence/${date}`);

    const requestaData = await request.json();

    console.log(requestaData);

    const tableBody = document.querySelector("#employeeAbsenceTable tbody");
    tableBody.innerHTML = "";

    requestaData.forEach((data) => {
        const tableRow = document.createElement("tr");
        Object.keys(data).forEach((key) => {
            const tableColumn = document.createElement("td");
            tableColumn.innerHTML = data[`${key}`];

            tableRow.append(tableColumn);
        });
        tableBody.append(tableRow);
    });

    return true;
}

document
    .getElementById("absencePeriod")
    .addEventListener("change", async (e) => {
        e.target.setAttribute("disabled", true);
        await populateAbsenceStats(e.target.value);
        e.target.removeAttribute("disabled");
    });
