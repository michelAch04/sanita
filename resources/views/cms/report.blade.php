@extends('cms.layout')

@section('title', 'Report')

@php
use Illuminate\Support\Str;

$metric = request('metric', 'customers');
$interval = request('interval', 'day');
$colors = [
'customers' => '#F6AD55',
'products' => '#F56565',
'brands' => '#9F7AEA',
'orders' => '#4299E1',
'categories' => '#48BB78',
'subcategories' => '#38B2AC',
'users' => '#75ac3e',
'revenue' => '#b1b459',
];
$lightcolors = [
'customers' => '#fee5b9', // item--1
'products' => '#FBD5D5', // item--2
'brands' => '#E9D8FD', // item--3
'orders' => '#D2E9F9', // item--4
'categories' => '#D6F5D6', // item--5
'subcategories' => '#CFF5F3', // item--6
'users' => '#c5fb8b', // item--7
'revenue' => '#eded79', // item--8
];

$color = $colors[$metric] ?? '#6ee7b7';
$bgColor = $lightcolors[$metric] ?? '#6ee7b7';
@endphp

@push('styles')
<style>
    nav {
        display: none !important;
    }

    main {
        margin-left: 0 !important;
        width: 100% !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    /* Apply different background ONLY when collapse is open */
    .list-group-item {
        background-color: {{$bgColor}} !important;
        border: none !important; /* 🔥 Removes the separator */
        transition: all 0.3s ease;
    }
</style>
@endpush

@section('content')
<div>
    <button onclick="window.close()" class="btn bubbles bubbles-grey">
        <span class="text"><i class="bi bi-arrow-left"></i> Back</span>
    </button>
</div>

<div class="container mt-3">
    <div class="card-header mb-5 text-center" style="color: {{ $color }}">
        <h2 class="mb-0">Report: {{ ucfirst($metric) }} — Grouped by {{ ucfirst($interval) }}</h4>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="bg-grey text-dark opacity-75">
                    <tr>
                        <th>{{ ucfirst($interval) }}</th>
                        <th>
                            @if($metric === 'revenue')
                            Total Revenue
                            @else
                            Total {{ ucfirst($metric) }}
                            @endif
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $group => $items)
                    <tr class="cursor-pointer toggle-row" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($group) }}">
                        <td>{{ $group }}</td>
                        <td>
                            @if ($metric === 'revenue')
                            ${{ number_format($items->sum('total_amount'), 2) }}
                            @else
                            {{ count($items) }}
                            @endif
                        </td>
                        <td><i class="bi bi-chevron-down toggle-icon"></i></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="p-0 border-0">
                            <div id="collapse-{{ Str::slug($group) }}" class="collapse">
                                <div class="p-0" style="background-color: {{ $bgColor }};">
                                    <ul class="list-group list-group-flush">
                                        @foreach($items as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            @if($metric === 'revenue')
                                            Order #{{ $item->id }} - ${{ number_format($item->total_amount, 2) }}
                                            @elseif($metric === 'customers')
                                            ID: {{ $item->id }} - {{ $item->first_name . ' ' . $item->last_name ?? 'No Name' }}
                                            @else
                                            {{ $item->name ?? 'ID: '.$item->id }}
                                            @endif
                                            <small class="text-muted">{{ $item->created_at->format('Y-m-d H:i') }}</small>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.toggle-row').forEach(row => {
            const icon = row.querySelector('.toggle-icon');
            const collapseId = row.getAttribute('data-bs-target');
            const collapseElement = document.querySelector(collapseId);

            collapseElement.addEventListener('show.bs.collapse', () => {
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
            });

            collapseElement.addEventListener('hide.bs.collapse', () => {
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            });
        });
    });
</script>
@endpush

@endsection