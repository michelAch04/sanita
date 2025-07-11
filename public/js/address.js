$(document).ready(function () {
    $(document).on("show.bs.modal", ".modal", function () {
        initAddressSelect2(this.id);
    });

    if (
        $("#addAddressModal").hasClass("show") ||
        $("#addAddressModal").is(":visible")
    ) {
        initAddressSelect2("addAddressModal");
    }
});

function confirmDelete(action) {
    const form = document.getElementById("deleteForm");
    form.action = action;
    const modal = new bootstrap.Modal(document.getElementById("deleteModal"));
    modal.show();
}

function initAddressSelect2(modalId) {
    let isEdit = modalId === "addAddressModal" ? "" : "edit_";

    const $govIn = $(`#${isEdit}governoratesInput`);
    const $disIn = $(`#${isEdit}districtsInput`);
    const $citIn = $(`#${isEdit}citiesInput`);

    const $govSelect = $(`#${isEdit}governorate`);
    const $disSelect = $(`#${isEdit}district`);
    const $citSelect = $(`#${isEdit}city`);

    const locale = window.locale || "en";

    $govSelect.select2({
        placeholder: window.addressMessages.selectGovernorate,
        allowClear: true,
        width: "95%",
        minimumResultsForSearch: 4,
        dropdownParent: $govIn,
    });

    let disableDistrictAndCity = modalId === "addAddressModal";

    $disSelect.select2({
        placeholder: window.addressMessages.selectDistrict,
        allowClear: true,
        width: "95%",
        minimumResultsForSearch: 4,
        dropdownParent: $disIn,
        disabled: disableDistrictAndCity,
    });

    $citSelect.select2({
        placeholder: window.addressMessages.selectCity,
        allowClear: true,
        width: "95%",
        minimumResultsForSearch: 4,
        dropdownParent: $citIn,
        disabled: disableDistrictAndCity,
    });

    $govSelect.on("change", function () {
        const governorateId = $(this).val();

        $disIn.addClass("o-50");
        $disSelect
            .html(`<option value="">${window.addressMessages.loading}</option>`)
            .prop("disabled", true);

        $citSelect
            .html(
                `<option value="">${window.addressMessages.selectCity}</option>`
            )
            .prop("disabled", true);

        $.ajax({
            url: `${window.url}/${locale}/get-districts`,
            data: { governorates_id: governorateId },
            success: function (data) {
                let options = `<option value="">${window.addressMessages.selectDistrict}</option>`;
                data.forEach((d) => {
                    const name = d[`name_${locale}`] || d.name_en;
                    options += `<option value="${d.id}">${name}</option>`;
                });
                $disSelect.html(options).prop("disabled", false);
                $disIn.removeClass("o-50");
            },
            error: function () {
                alert("Failed to load districts.");
            },
        });
    });

    $disSelect.on("change", function () {
        const districtId = $(this).val();

        $citIn.addClass("o-50");
        $citSelect
            .html(`<option value="">${window.addressMessages.loading}</option>`)
            .prop("disabled", true);

        $.ajax({
            url: `${window.url}/${locale}/get-cities`,
            data: { districts_id: districtId },
            success: function (data) {
                let options = `<option value="">${window.addressMessages.selectCity}</option>`;
                data.forEach((c) => {
                    const name = c[`name_${locale}`] || c.name_en;
                    options += `<option value="${c.id}">${name}</option>`;
                });
                $citSelect.html(options).prop("disabled", false);
                $citIn.removeClass("o-50");
            },
            error: function () {
                alert("Failed to load cities.");
            },
        });
    });
}
