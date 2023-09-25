<div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $title === 'Waiting For Verification Fasilitators' ? 'active' : '' }}"
                href="/waiting-for-verification/fasilitators">Yang Menunggu
                Verifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Verified Fasilitators' ? 'active' : '' }}"
                href="/verified/fasilitators">Yang Diverifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Rejected Fasilitators' ? 'active' : '' }}"
                href="/rejected/fasilitators">Yang Ditolak</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'All Fasilitators' ? 'active' : '' }}" href="/all/fasilitators">Semua</a>
        </li>
    </ul>
</div>
