@extends('public.member_dashboard.dashboard_master')

@section('title', 'My Notifications')

@section('notification', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-order">
    <div class="title">
        <h2>My Notifications</h2>
        <span class="title-leaf title-leaf-gray">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <div class="order-tab dashboard-bg-box">
        <div class="table-responsive" style="min-height: 400px;">
            <table class="table order-table">
                <tbody>
                    <tr>
                        <th class="text-center">#SN</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    @foreach ($notification_recipients as $key => $notification_recipient)
                    <tr>
                        <td class="text-center">
                            #{{ ++$key }}
                        </td>
                        <td class="text-center">
                            {{ $notification_recipient->subject }}
                        </td>

                        <td class="text-center">
                        {{ date('jS M Y', strtotime($notification_recipient->send_date)) }}
                        </td>

                        <td class="text-center d-flex justify-content-center">
                            <div class="dropdown">
                                <button style="background-color: #0baf9a; color: #fff; padding: 6px; font-size: 14px;" class="btn dropdown-toggle" type="button" id="dropdownActiove" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-tools me-1"></i> Action
                                </button>
                                <ul style="min-width: 6rem; font-size: 14px;" class="dropdown-menu" aria-labelledby="dropdownActiove">
                                    <a class="dropdown-item" href="{{ route('dashboard.notification.show', $notification_recipient->id) }}">
                                        <i class="fa fa-eye"></i> Show
                                    </a>
                                </ul>
                              </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($notification_recipients->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $notification_recipients->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $notification_recipients->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($notification_recipients->getUrlRange(1, $notification_recipients->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $notification_recipients->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                <li class="page-item {{ $notification_recipients->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $notification_recipients->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@endpush
