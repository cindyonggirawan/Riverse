<nav class="row tab-menu">
    <div class="{{ $title === 'Unapproved Joined Sukarelawan' ? 'tab-selected' : 'tab-unselected' }}">
        <a class="tab-link {{ $title === 'Unapproved Joined Sukarelawan' ? 'active' : '' }}"
            href="/{{ $activity->slug }}/waiting-for-verification/joinedSukarelawanAttendance">Yang Terdaftar</a>
    </div>
    <div class="{{ $title === 'Unapproved Clocked In Sukarelawan' ? 'tab-selected' : 'tab-unselected' }}">
        <a class="tab-link {{ $title === 'Unapproved Clocked In Sukarelawan' ? 'active' : '' }}"
            href="/{{ $activity->slug }}/waiting-for-verification/clockedInSukarelawanAttendance">Yang Absen</a>
    </div>
    <div class="{{ $title === 'Approved Sukarelawan' ? 'tab-selected' : 'tab-unselected' }}">
        <a class="tab-link {{ $title === 'Approved Sukarelawan' ? 'active' : '' }}"
            href="/{{ $activity->slug }}/verified/claimedSukarelawanAttendance">Yang Hadir</a>
    </div>
</nav>
