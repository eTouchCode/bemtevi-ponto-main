import "./bootstrap";
import Choices from "choices.js";
import "./masks";
import "animate.css";

document.querySelectorAll("a.btnDeleteEntry").forEach((elem) => {
    elem.addEventListener("click", (e) => {
        e.preventDefault();
        const prompt = window.confirm("Confirm to delete");

        if (prompt) {
            const deleteLocation = elem.getAttribute("href");
            window.location.replace(deleteLocation);
        }
    });
});
const genericSelect = document.querySelectorAll("select.choices");
const employeeDashboardSelect = document.getElementById(
    "dashboardEmployeeSearch"
);
const addtionalSearch = document.querySelector("select.searchBoxAdditional");

genericSelect.forEach((elem) => {
    const choices = new Choices(elem, {
        allowHTML: true,
        searchEnabled: elem.dataset.search ? true : false,
        classNames: {
            containerInner: "choices__inner text-dark",
            item: "choices__item",
            highlightedState: "text-dark",
            selectedState: "text-dark",
        },
    });
});

const settingsButton = document.querySelectorAll("button.settingsButton");
if (settingsButton) {
    settingsButton.forEach((elem) => {
        elem.addEventListener("click", (e) => {
            const parent = elem.closest(".accordion-item");
            const icon = elem.querySelector(".material-icons");
            const accordionBody = parent.querySelector(".accordion-collapse");

            accordionBody.addEventListener("hidden.bs.collapse", function () {
                icon.textContent = "add";
            });
            accordionBody.addEventListener("shown.bs.collapse", function () {
                icon.textContent = "remove";
            });
        });
    });
}

if (addtionalSearch) {
    const addSearch = new Choices(addtionalSearch, {
        allowHTML: true,
        searchEnabled: true,
        searchChoices: true,
        classNames: {
            containerInner: "choices__inner text-dark",
            item: "choices__item",
            highlightedState: "text-dark",
            selectedState: "text-dark",
        },
    });
}

const clock = document.getElementById("clockDisplay");

if (clock) {
    function showTime() {
        let date = new Date();
        const time = date.toLocaleTimeString("en-GB");
        clock.innerText = time;
        clock.textContent = time;
        setTimeout(showTime, 1000);
    }

    showTime();
}
