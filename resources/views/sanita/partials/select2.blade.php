@php
$select2id = $id ?? null;
$select2placeholder = $placeholder ?? null;

@endphp
{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script>
    $(document).ready(function() {
        $('{{ $select2id }}').select2({
            placeholder: '{{ $select2placeholder }}',
            allowClear: true,
            width: '100%'
        });
    });
</script>

{{-- Styles --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('css/select2-style.css') }}" rel="stylesheet" />