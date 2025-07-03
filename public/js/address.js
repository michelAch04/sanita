$(document).ready(function () {
    $(document).on(`show.bs.modal`, `.modal`, function (e) {
        let isEdit = ``;
        if (this.id === `addAddressModal`) {
            isEdit = ``;
        } else {
            isEdit = `edit_`;
        }

        var $govIn = $(`#${isEdit}governoratesInput`);
        var $disIn = $(`#${isEdit}districtsInput`);
        var $citIn = $(`#${isEdit}citiesInput`);

        $(`#${isEdit}governorate`).select2({
            placeholder: `${window.addressMessages.selectGovernorate}`,
            allowClear: true,
            width: `95%`,
            minimumResultsForSearch: 4,
            dropdownParent: $govIn,
        });

        // Only disable district/city if it's NOT the edit modal
        let disableDistrictAndCity = this.id === "addAddressModal";

        $(`#${isEdit}district`).select2({
            placeholder: `${window.addressMessages.selectDistrict}`,
            allowClear: true,
            width: `95%`,
            minimumResultsForSearch: 4,
            dropdownParent: $disIn,
            disabled: disableDistrictAndCity,
        });

        $(`#${isEdit}city`).select2({
            placeholder: `${window.addressMessages.selectCity}`,
            allowClear: true,
            width: `95%`,
            minimumResultsForSearch: 4,
            dropdownParent: $citIn,
            disabled: disableDistrictAndCity,
        });

        $(`#${isEdit}governorate`).on(`change`, function () {
            const governorateId = $(this).val();
            $disIn.addClass(`o-50`);
            $(`#${isEdit}district`)
                .html(
                    `<option value="">${window.addressMessages.loading}</option>`
                )
                .prop(`disabled`, true);
            $(`#${isEdit}city`)
                .html(
                    `<option value="">${window.addressMessages.selectCity}</option>`
                )
                .prop(`disabled`, true);

            $.ajax({
                url: `${window.url}/${window.locale}/get-districts`,
                data: {
                    governorates_id: governorateId,
                },
                success: function (data) {
                    $(`#${isEdit}district`).html(
                        `<option value="">${window.addressMessages.selectDistrict}</option>`
                    );
                    data.forEach((d) => {
                        $(`#${isEdit}district`).append(
                            `<option value="${d.id}">${d.name_en}</option>`
                        );
                    });
                    $disIn.removeClass(`o-50`);
                    $(`#${isEdit}district`).prop(`disabled`, false); // Re-enable after loading
                },
            });
        });

        $(`#${isEdit}district`).on(`change`, function () {
            const districtId = $(this).val();
            $(`#${isEdit}city`)
                .html(
                    `<option value="">${window.addressMessages.loading}</option>`
                )
                .prop(`disabled`, true);
            $citIn.addClass(`o-50`);

            $.ajax({
                url: `${window.url}/${window.locale}/get-cities`,
                data: {
                    districts_id: districtId,
                },
                success: function (data) {
                    $(`#${isEdit}city`).html(
                        `<option value="">${window.addressMessages.selectCity}</option>`
                    );
                    data.forEach((c) => {
                        $(`#${isEdit}city`).append(
                            `<option value="${c.id}">${c.name_en}</option>`
                        );
                    });
                    $citIn.removeClass(`o-50`);
                    $(`#${isEdit}city`).prop(`disabled`, false); // Re-enable after loading
                },
            });
        });
    });
});

function confirmDelete(action) {
    const form = document.getElementById("deleteForm");
    form.action = action;
    const modal = new bootstrap.Modal(document.getElementById("deleteModal"));
    modal.show();
}
