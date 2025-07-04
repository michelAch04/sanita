$(document).ready(function () {
    $(document).on('show.bs.modal', '.modal', function () {
        initAddressSelect2(this.id);
    });

    // If the modal is already visible on page load, initialize select2 immediately
    if ($('#addAddressModal').hasClass('show') || $('#addAddressModal').is(':visible')) {
        initAddressSelect2('addAddressModal');
    }
});

function initAddressSelect2(modalId) {
    const isEdit = modalId === 'addAddressModal' ? '' : 'edit_';

    const $govIn = $(`#${isEdit}governoratesInput`);
    const $disIn = $(`#${isEdit}districtsInput`);
    const $citIn = $(`#${isEdit}citiesInput`);

    const $governorate = $(`#${isEdit}governorate`);
    const $district = $(`#${isEdit}district`);
    const $city = $(`#${isEdit}city`);

    // Disable district and city if modal is 'addAddressModal'
    const disableDistrictAndCity = modalId === 'addAddressModal';

    // Initialize Select2 for governorate, district, and city
    $governorate.select2({
        placeholder: window.addressMessages.selectGovernorate,
        allowClear: true,
        width: '95%',
        minimumResultsForSearch: 4,
        dropdownParent: $govIn
    });

    $district.select2({
        placeholder: window.addressMessages.selectDistrict,
        allowClear: true,
        width: '95%',
        minimumResultsForSearch: 4,
        dropdownParent: $disIn,
        disabled: disableDistrictAndCity
    });

    $city.select2({
        placeholder: window.addressMessages.selectCity,
        allowClear: true,
        width: '95%',
        minimumResultsForSearch: 4,
        dropdownParent: $citIn,
        disabled: disableDistrictAndCity
    });

    // Handle governorate change event
    $governorate.off('change').on('change', function () {
        const governorateId = $(this).val();

        // Visual loading state for district and city
        $disIn.addClass('o-50');
        $district.html(`<option value="">${window.addressMessages.loading}</option>`).prop('disabled', true);
        $city.html(`<option value="">${window.addressMessages.selectCity}</option>`).prop('disabled', true);

        // Fetch districts based on selected governorate
        $.ajax({
            url: `${window.url}/${window.locale}/get-districts`,
            data: { governorates_id: governorateId },
            success: function (data) {
                $district.html(`<option value="">${window.addressMessages.selectDistrict}</option>`);
                data.forEach(d => {
                    $district.append(`<option value="${d.id}">${d.name_en}</option>`);
                });
                $disIn.removeClass('o-50');
                $district.prop('disabled', false);
            }
        });
    });

    // Handle district change event
    $district.off('change').on('change', function () {
        const districtId = $(this).val();

        $citIn.addClass('o-50');
        $city.html(`<option value="">${window.addressMessages.loading}</option>`).prop('disabled', true);

        // Fetch cities based on selected district
        $.ajax({
            url: `${window.url}/${window.locale}/get-cities`,
            data: { districts_id: districtId },
            success: function (data) {
                $city.html(`<option value="">${window.addressMessages.selectCity}</option>`);
                data.forEach(c => {
                    $city.append(`<option value="${c.id}">${c.name_en}</option>`);
                });
                $citIn.removeClass('o-50');
                $city.prop('disabled', false);
            }
        });
    });
}

function confirmDelete(action) {
    const form = document.getElementById('deleteForm');
    form.action = action;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
