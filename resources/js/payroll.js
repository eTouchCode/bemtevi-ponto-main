import Choices from "choices.js";
import IMask, { MaskedNumber } from "imask";

const employeeSearch = document.querySelector("select.searchBoxEmployee");
const payRollForm = document.querySelector("#payRollForm");
const additionalPaymentValues = document.querySelector(
    "#additionalPaymentValues"
);
const addAdditionalPayment = document.getElementById("addAdditionalPayment");

const fetchEndpoint = "/payroll/fetchEmployee";
const currencyFormat = new Intl.NumberFormat("pt-BR", {
    style: "currency",
    currency: "BRL",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

const empSearch = new Choices(employeeSearch, {
    allowHTML: true,
    searchEnabled: true,
    searchChoices: true,
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

const addAdditional = new Choices(addAdditionalPayment, {
    allowHTML: true,
    searchEnabled: true,
    searchChoices: true,
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

addAdditionalPayment.addEventListener("change", async (event) => {
    const additionalId = event.detail.value;
    const existingAdditional = document.querySelector(
        `#additionalValuesTable tbody tr[data-additional-id="${additionalId}"]`
    );
    const tableBody = additionalPaymentValues.querySelector("tbody");

    if (existingAdditional) {
        return;
    }

    const response = await fetch(`/payroll/fetchAdditional/${additionalId}`);

    const responseData = await response.json();

    addAdditionals(responseData, tableBody);
});

employeeSearch.addEventListener("change", async (event) => {
    const employeeId = event.detail.value;
    if (!employeeId) {
        return;
    }

    const response = await fetch(
        `/payroll/fetchEmployeeAdditionals/${employeeId}`
    );
    const responseData = await response.json();

    document.getElementById("additionalValuesTable").classList.remove("d-none");
    const tableBody = additionalPaymentValues.querySelector("tbody");

    tableBody.innerHTML = "";

    responseData.data.forEach((element) => {
        addAdditionals(element, tableBody);
    });
});

function additionalValueSetOldValue(event) {
    if (!event.target.value) {
        event.target.value = event.target.getAttribute("oldValue");
    }
}

function removeAdditional(event) {
    event.target.closest("tr").remove();
}

function addAdditionals(element, tableBody) {
    const tableRow = tableBody.insertRow(tableBody.rows.length);
    tableRow.dataset.additionalId = element.id;

    const additional = {
        name: element.name,
        amount: element.amount,
        percentageValue: element.percentageValue,
    };

    let count = 0;
    Object.keys(additional).forEach((value) => {
        const tableCol = tableRow.insertCell(count);
        tableCol.classList.add("align-middle");
        switch (value) {
            case "amount":
                const amount = document.createElement("input");
                amount.type = "text";
                amount.classList.add(
                    "bg-transparent",
                    "border-0",
                    "additionalValue"
                );
                amount.value = element[value];
                amount.setAttribute("oldValue", element["amount"]);
                amount.addEventListener("change", additionalValueSetOldValue);
                amount.name = `additionals[${element["id"]}][amount]`;

                IMask(amount, {
                    mask: MaskedNumber, // enable number mask

                    // other options are optional with defaults below
                    scale: 2, // digits after point, 0 for integers
                    thousandsSeparator: ",", // any single char
                    padFractionalZeros: true, // if true, then pads zeros at end to the length of scale
                    normalizeZeros: true, // appends or removes zeros at ends
                    radix: ".", // fractional delimiter
                    mapToRadix: [","], // symbols to process as radix

                    // additional number interval options (e.g.)
                    min: 0,
                    autofix: true,
                });

                tableCol.append(amount);
                break;
            case "name":
                const additionalName = document.createElement("h6");
                additionalName.classList.add("text-bold");
                additionalName.innerText = element[value];
                tableCol.append(additionalName);
                break;
            case "percentageValue":
                const percentageDiv = document.createElement("div");
                percentageDiv.classList.add("form-check", "form-switch");

                const percentage = document.createElement("input");
                percentage.type = "checkbox";
                percentage.classList.add("form-check-input");
                if (element[value]) {
                    percentage.setAttribute("checked", true);
                }
                percentage.name = `additionals[${element["id"]}][percentageValue]`;

                percentageDiv.append(percentage);
                tableCol.append(percentageDiv);
                break;
        }

        count++;
    });
    const removeCol = tableRow.insertCell();
    const removeBtn = document.createElement("button");
    removeBtn.type = "button";
    removeBtn.classList.add("btn", "btn-danger", "removeAddBtn", "m-0");
    removeBtn.innerHTML = `<i class="material-icons">close</i>`;
    removeBtn.addEventListener("click", removeAdditional);
    removeCol.append(removeBtn);
}

payRollForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(payRollForm);
    const response = await fetch(fetchEndpoint, {
        method: "POST",
        body: formData,
    });

    const responseData = await response.json();

    Object.keys(responseData.bases).forEach((val, index) => {
        const element = responseData.bases[val];
        const input = document.createElement("input");

        input.type = "hidden";
        input.value = element;
        input.setAttribute("name", `bases[${val}]`);

        document.getElementById("createPayrollForm").prepend(input);
    });

    document.querySelector("#payment_date").value =
        document.querySelector("#period").value;

    document.querySelector("#employee_id").value = responseData.employee.id;

    const salaryInput = document.querySelector("#employeeSalary input");
    salaryInput.value = currencyFormat.format(
        responseData.employee.position.salary.amount
    );

    Object.keys(responseData.taxRates).forEach((key) => {
        const element = responseData.taxRates[key];
        document.querySelector(
            `.taxRate#${element.name}`
        ).innerHTML = `(${element.percentage}%)`;

        document.querySelector(
            `#${element.name.toLowerCase()}Contribution`
        ).value = element.percentage;
    });
    Object.keys(responseData.contributions).forEach((key) => {
        document.querySelector(
            `.taxResult[data-tax='${key}']`
        ).childNodes[1].value = currencyFormat.format(
            responseData.contributions[key]
        );
    });

    const additionalTable = document.getElementById("additionalPaymentsTable");

    const additionalTableBody =
        additionalTable.getElementsByTagName("tbody")[0];

    const additionalTableFoot =
        additionalTable.getElementsByTagName("tfoot")[0];

    additionalTableBody.innerHTML = "";
    responseData.additionals.forEach((element, index) => {
        const tableRow = additionalTableBody.insertRow(
            additionalTableBody.rows.length
        );

        const additional = {
            name: element.name,
            value: element.value,
        };
        let count = 0;
        Object.keys(additional).forEach((key) => {
            const input = document.createElement("input");
            input.type = "text";
            input.classList.add("bg-transparent", "border-0");
            input.setAttribute("readonly", true);
            const cell = element[key];
            const tableCell = tableRow.insertCell(count);
            tableCell.appendChild(input);

            if (typeof cell === "object") {
                if (!cell.percentage) {
                    input.value = `${currencyFormat.format(cell.amount)}`;
                } else {
                    input.value = `${currencyFormat.format(cell.amount)}(${
                        element.value.percentageValue
                    }%)`;
                }
            } else if (typeof cell === "string") {
                input.value = cell;
            } else {
                input.value = currencyFormat.format(cell);
            }
            input.setAttribute("name", `additionals[${index}][${key}]`);
            count++;
        });
    });

    if (responseData.additionals.length > 0) {
        document
            .getElementById("additionalPaymentsContainer")
            .classList.remove("d-none");
    }

    document.querySelector("#employeeDiscount input").value =
        currencyFormat.format(responseData.summary.employee.discounts);

    document.querySelector("#employeeINSS input").value = currencyFormat.format(
        responseData.summary.employee.inss_amount
    );

    document.querySelector("#employeeIR input").value = currencyFormat.format(
        responseData.summary.employee.ir_amount
    );

    document.querySelector("#summaryEmployeeSalary input").value =
        currencyFormat.format(responseData.summary.employee.salary);

    document.querySelector("#companyEmployeeSalary input").value =
        currencyFormat.format(responseData.summary.company.salary);

    document.querySelector("#companyEmployeeValue input").value =
        currencyFormat.format(responseData.summary.company.totalValue);
    document.querySelector("#companyInss input").value = currencyFormat.format(
        responseData.summary.company.inss_amount
    );
    document.querySelector("#companyFGTS input").value = currencyFormat.format(
        responseData.summary.company.fgts_amount
    );

    document
        .getElementById("payRollSummaryContainer")
        .classList.remove("d-none");
});
