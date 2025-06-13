@extends('cms.layout')

@section('title', 'Dashboard')

@section('content')
@push('styles')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
@endpush
<div class="container">
    <!-- Welcome Message -->
    <div class="text-center mb-5 fw-bold">
        <h1 class="display-4">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-muted">Here's an overview of the system's statistics in the last 7 days.</p>
    </div>

    <div class="info-card">
        {{-- New Customers --}}
        <div class="item item--1" data-metric="customers" onclick="openMetricModal(this)">
            <i class="bi bi-people-fill i--1"></i>
            <span class="quantity">{{ round($stats['customers'], 1) }}+</span>
            <span class="text text--1">New Customers</span>
        </div>

        {{-- Products Created --}}
        <div class="item item--2" data-metric="products" onclick="openMetricModal(this)">
            <i class="bi bi-box-fill i--2"></i>
            <span class="quantity">{{ round($stats['products'], 1) }}+</span>
            <span class="text text--2">Products Created</span>
        </div>

        {{-- Brands Created --}}
        <div class="item item--3" data-metric="brands" onclick="openMetricModal(this)">
            <i class="bi bi-tags-fill i--3"></i>
            <span class="quantity">{{ round($stats['brands'], 1) }}+</span>
            <span class="text text--3">Brands Created</span>
        </div>

        {{-- Orders Processed --}}
        <div class="item item--4" data-metric="orders" onclick="openMetricModal(this)">
            <i class="bi bi-cart-fill i--4"></i>
            <span class="quantity">{{ round($stats['orders'], 1) }}+</span>
            <span class="text text--4">Orders Processed</span>
        </div>

        {{-- Categories Created --}}
        <div class="item item--5" data-metric="categories" onclick="openMetricModal(this)">
            <i class="bi bi-collection-fill i--5"></i>
            <span class="quantity">{{ round($stats['categories'], 1) }}+</span>
            <span class="text text--5">Categories Created</span>
        </div>

        {{-- Subcategories Created --}}
        <div class="item item--6" data-metric="subcategories" onclick="openMetricModal(this)">
            <i class="bi bi-diagram-3-fill i--6"></i>
            <span class="quantity">{{ round($stats['subcategories'], 1) }}+</span>
            <span class="text text--6">Subcategories Created</span>
        </div>

        {{-- Admin Users --}}
        <div class="item item--7" data-metric="users" onclick="openMetricModal(this)">
            <i class="bi bi-people-fill i--7"></i>
            <span class="quantity">{{ round($stats['admins'], 1) }}</span>
            <span class="text text--7">Active Admins</span>
        </div>

        {{-- Total Revenue --}}
        <div class="item item--8" data-metric="revenue" onclick="openMetricModal(this)">
            <i class="bi bi-currency-dollar i--8"></i>
            <span class="quantity">${{ number_format($stats['total_amount'], 1) }}+</span>
            <span class="text text--8">Total Revenue</span>
        </div>
    </div>

    <!-- Report Generation Modal -->
    <div class="modal fade" id="metricModal" tabindex="-1" aria-labelledby="metricModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="metricModalLabel">Generate Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        <input type="hidden" id="metricType" name="metric">

                        <div class="mb-3">
                            <label for="startDate" class="form-label">From:</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="endDate" class="form-label">To:</label>
                            <input type="date" class="form-control" id="endDate" name="end_date" required>
                        </div>

                        <div class="select-container mb-3 mt-4">
                            <label class="label">Time interval</label>
                            <div class="mt-2" style="justify-content: start !important;">
                                <label class="select-label"><input type="radio" name="interval" value="day"> <span>Day</span></label>
                                <label class="select-label"><input type="radio" name="interval" value="week"> <span>Week</span></label>
                                <label class="select-label"><input type="radio" name="interval" value="month"> <span>Month</span></label>
                                <label class="select-label"><input type="radio" name="interval" value="year"> <span>Year</span></label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4" style="gap: 0.3rem !important;">
                            <button type="button" class="btn bubbles bubbles-grey" onclick="hideModal()">
                                <span class="text">Cancel</span>
                            </button>
                            <button type="submit" class="btn bubbles" id="generateBtn">
                                <span class="text">Generate</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function openMetricModal(element) {
        const metricColors = {
            'item--1': '#e6c189', // darker version of #fedba0
            'item--2': '#e6aaaa', // darker version of #ffc5c5
            'item--3': '#cbb0e6', // darker version of #e3cbff
            'item--4': '#9cc8e3', // darker version of #bbe1fc
            'item--5': '#9cd89c', // darker version of #b8efb8
            'item--6': '#99d5d2', // darker version of #baf0ed
            'item--7': '#9ad959', // darker version of #b4f371
            'item--8': '#c4c444', // darker version of #e4e460
        };

        const metric = element.getAttribute('data-metric');
        const modalHeader = document.querySelector('#metricModal .modal-header');
        const generateButton = document.getElementById('generateBtn');

        // --------------------- MODIFY STYLING BASED ON SELECTED DIV --------------------------- //
        const classList = Array.from(element.classList);
        const itemClass = classList.find(cls => cls.startsWith('item--'));

        // Look up background color
        const bgColor = metricColors[itemClass] || '#000'; // fallback color

        // Apply to modal header
        modalHeader.style.backgroundColor = bgColor;
        modalHeader.style.color = '#fff'; // optional
        // Optional: You could update modal title dynamically
        document.getElementById('metricModalLabel').textContent = `Generate Report: ${metric.charAt(0).toUpperCase() + metric.slice(1)}`;

        generateButton.style.setProperty('--c2', bgColor);
        // Apply dynamic styles to focus/select inputs
        const styleId = 'dynamic-theme-style';
        let styleTag = document.getElementById(styleId);
        if (!styleTag) {
            styleTag = document.createElement('style');
            styleTag.id = styleId;
            document.head.appendChild(styleTag);
        }

        styleTag.innerHTML = `
            .select-container input[type="radio"]:checked + span {
                box-shadow: 0 0 0 0.0625em ${bgColor};
                background-color: ${bgColor}22; /* light transparent bg */
                color: ${bgColor};
            }

            .form-control:focus {
                box-shadow: 0 3px 10px ${bgColor}cc;
                border: 0;
            }

            .select-label span {
                transition: all 0.3s ease;
            }

            .select-container:focus,
            .select-label:focus {
                outline: none;
                border-color: ${bgColor};
                box-shadow: 0 0 0 4px ${bgColor}99;
            }
        `;

        // --------------------- END OF MODIFY STYLING --------------------------- //

        document.getElementById('metricType').value = metric; // 👈 ADD THIS LINE
        const modal = new bootstrap.Modal(document.getElementById('metricModal'));
        modal.show();
    }

    document.getElementById('reportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('hi');
        const metric = document.getElementById('metricType').value;
        console.log(metric);
        const startDate = document.getElementById('startDate').value;
        console.log(startDate);
        const endDate = document.getElementById('endDate').value;
        console.log(endDate);
        const interval = document.querySelector('input[name="interval"]:checked')?.value;
        console.log(interval);

        if (!metric || !startDate || !endDate || !interval) return;

        const url = new URL('{{ route("report.show") }}', window.location.origin);
        url.searchParams.append('metric', metric);
        url.searchParams.append('start_date', startDate);
        url.searchParams.append('end_date', endDate);
        url.searchParams.append('interval', interval);
        console.log(url.toString());

        window.open(url.toString(), '_blank');
    });

    function hideModal() {
        const modal = document.getElementById('metricModal');
        const mymodal = bootstrap.Modal.getInstance(modal);
        mymodal.hide();
    }
</script>
@endpush

@endsection