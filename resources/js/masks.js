import flatpickr from "flatpickr";
import { Portuguese } from "flatpickr/dist/l10n/pt";
const { add } = require("date-fns");
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect";
import rangePlugin from "flatpickr/dist/plugins/rangePlugin";

import IMask, { MaskedNumber } from "imask";

document.addEventListener("DOMContentLoaded", function (e) {
    const cpf = this.querySelectorAll("input.cpf");
    const cep = this.querySelectorAll("input.cep");
    const cepWEvent = this.querySelectorAll("input.cepMask");
    const phone = this.querySelectorAll("input.phone");
    const money = this.querySelectorAll("input.money");
    const time = this.querySelectorAll("input.time");
    const timeRange = this.querySelectorAll("input.timeRange");
    const vacationDateRange = this.querySelectorAll(
        "input#dateRangeVacationStart"
    );
    const dateInput = this.querySelectorAll('input[type="date"]');
    const date = this.querySelectorAll("input.date");
    const datePeriod = this.querySelectorAll("input.datePeriod");

    cpf.forEach((elem) => {
        const mask = IMask(elem, {
            mask: "000.000.000-00",
        });
    });

    cep.forEach((elem) => {
        const mask = IMask(elem, {
            mask: "00000-000",
        });
    });

    cepWEvent.forEach((elem) => {
        const mask = IMask(elem, {
            mask: "00000-000",
        });

        mask.on("complete", async () => {
            const addressInput = document.querySelectorAll(
                'input[name="address"]'
            );
            const complementInput = document.querySelectorAll(
                'input[name="complement"]'
            );
            const neighborhoodInput = document.querySelectorAll(
                'input[name="neighborhood"]'
            );

            addressInput.forEach((thisElem) =>
                thisElem.setAttribute("readonly", "true")
            );
            complementInput.forEach((thisElem) =>
                thisElem.setAttribute("readonly", "true")
            );
            neighborhoodInput.forEach((thisElem) =>
                thisElem.setAttribute("readonly", "true")
            );

            const strippedVal = elem.value.replace(/\D/g, "");
            if (strippedVal != "") {
                const regexCEP = /^[0-9]{8}$/;

                if (regexCEP.test(strippedVal)) {
                    let response = await fetch(
                        `http://viacep.com.br/ws/${strippedVal}/json/ `
                    );

                    response = await response.json();
                    console.log(response);
                    if (!response.erro) {
                        addressInput.forEach(
                            (thisElem) => (thisElem.value = response.logradouro)
                        );
                        complementInput.forEach(
                            (thisElem) =>
                                (thisElem.value = response.complemento)
                        );
                        neighborhoodInput.forEach(
                            (thisElem) => (thisElem.value = response.bairro)
                        );
                    } else {
                        addressInput.forEach((thisElem) =>
                            thisElem.removeAttribute("readonly")
                        );
                        complementInput.forEach((thisElem) =>
                            thisElem.removeAttribute("readonly")
                        );
                        neighborhoodInput.forEach((thisElem) =>
                            thisElem.removeAttribute("readonly")
                        );
                    }
                }
            }
        });
    });

    phone.forEach((elem) => {
        const mask = IMask(elem, {
            mask: [
                {
                    mask: "(00) 0000-0000",
                },
                {
                    mask: "(00) 00000-0000",
                },
            ],
        });
    });

    money.forEach((elem) => {
        const mask = IMask(elem, {
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
    });

    dateInput.forEach((elem) => {
        const datePickr = flatpickr(elem, {
            locale: Portuguese,
            theme: "dark",
            altInput: true,
            altFormat: "d \\d\\e F \\d\\e Y",
            dateFormat: "Y-m-d",
        });
    });

    time.forEach((elem) => {
        const timePickr = flatpickr(elem, {
            locale: Portuguese,
            theme: "dark",
            enableTime: true,
            defaultHour: 0,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
        });
    });

    timeRange.forEach((elem) => {
        const timeRangePickr = flatpickr(elem, {
            locale: Portuguese,
            theme: "dark",
            mode: "range",
            minDate: "today",
            dateFormat: "m-d",
        });
    });

    vacationDateRange.forEach((elem) => {
        const dateMax = elem.dataset.max;
        const vacationDateRange = flatpickr(elem, {
            locale: { ...Portuguese, rangeSeparator: " | " },
            theme: "dark",
            mode: "range",
            altInput: true,
            altFormat: "j \\d\\e F",
            dateFormat: "Y-m-d",
            onClose: function (selectedDates, dateStr, instance) {
                const startingDay = selectedDates[0];
                const endingDay = selectedDates[1];

                const diffDays = Math.floor(
                    Math.abs(startingDay - endingDay) / (1000 * 60 * 60 * 24)
                );

                if (diffDays > dateMax) {
                    alert(
                        `Diferença de dias maior que o valor configurado (${dateMax} dias)`
                    );
                    instance.clear();

                    instance.setDate([
                        startingDay,
                        add(startingDay, {
                            days: 15,
                        }),
                    ]);
                }
            },
        });
    });

    date.forEach((elem) => {
        const datePickr = flatpickr(elem, {
            locale: Portuguese,
            theme: "dark",
            altInput: true,
            altFormat: "j \\d\\e F",
            dateFormat: "m-d",
        });
    });

    datePeriod.forEach((elem) => {
        const now = new Date();
        const currentMonth = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastMonth = new Date(
            now.getFullYear(),
            currentMonth.getMonth() - 1,
            1
        );

        const periodPicker = flatpickr(elem, {
            locale: Portuguese,
            defaultDate: currentMonth,
            minDate: lastMonth,
            altInput: true,
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "m-Y",
                    altFormat: "F/Y",
                    theme: "dark",
                }),
            ],
        });
    });
});
