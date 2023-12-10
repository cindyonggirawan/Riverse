@include('layout.useBootstrap')

<div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $title === 'Unapproved Sukarelawan' ? 'active' : '' }}"
                href="/{{ $activity->slug }}/waiting-for-verification/attendance">Yang Menunggu
                Verifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Approved Sukarelawan' ? 'active' : '' }}"
                href="/{{ $activity->slug }}/attended/attendance">Yang Diverifikasi</a>
        </li>
    </ul>
</div>
