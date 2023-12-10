<nav class="row tab-menu">
    <div class="{{ $title === 'Unapproved Sukarelawan' ? 'tab-selected' : 'tab-unselected' }}">
        <a class="tab-link {{ $title === 'Unapproved Sukarelawan' ? 'active' : '' }}"
        href="/{{ $activity->slug }}/waiting-for-verification/attendance">Yang Menunggu Verifikasi</a>
    </div>
    <div class="{{ $title === 'Approved Sukarelawan' ? 'tab-selected' : 'tab-unselected' }}">
        <a class="tab-link {{ $title === 'Approved Sukarelawan' ? 'active' : '' }}"
        href="/{{ $activity->slug }}/attended/attendance">Yang Diverifikasi</a>
    </div>
</nav>
