<div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $title === 'Waiting For Verification Sukarelawans' ? 'active' : '' }}"
                href="/waiting-for-verification/sukarelawans">Yang Menunggu
                Verifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Verified Sukarelawans' ? 'active' : '' }}"
                href="/verified/sukarelawans">Yang Diverifikasi</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'Rejected Sukarelawans' ? 'active' : '' }}"
                href="/rejected/sukarelawans">Yang Ditolak</a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $title === 'All Sukarelawans' ? 'active' : '' }}" href="/all/sukarelawans">Semua</a>
        </li>
    </ul>
</div>
