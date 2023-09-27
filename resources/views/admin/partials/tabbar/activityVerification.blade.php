<div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $title === 'Waiting For Verification Activities' ? 'active' : '' }}"
                href="/waiting-for-verification/activities">Yang Menunggu
                Verifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Verified Activities' ? 'active' : '' }}" href="/verified/activities">Yang
                Diverifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Rejected Activities' ? 'active' : '' }}" href="/rejected/activities">Yang
                Ditolak</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'All Activities' ? 'active' : '' }}" href="/all/activities">Semua</a>
        </li>
    </ul>
</div>
