@extends('layout.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/activity.css') }}" />
@endsection

@section('content')
    <h1>{{ '1.000' }} aktivitas membutuhkan bantuan</h1>
    <div class="activities-body">
        <div class="filter">
            <p>Filter</p>
            <form action="{{ route('activities.index') }}" method="GET">
                <div class="filter-box">
                    <h5>Judul Aktivitas</h5>
                    <div class="search-container">
                        <input class="searchbox" type="text" id="searchActivity" name="searchActivity"
                            placeholder="Cari Aktivitas" value="{{ $searchActivity ?? '' }}">
                        <button class="search-button" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.6435 12.2923C14.8313 10.761 15.3911 8.83464 15.209 6.9052C15.0269 4.97576 14.1166 3.18816 12.6633 1.90607C11.21 0.62398 9.32284 -0.0562918 7.38576 0.00364974C5.44867 0.0635913 3.60718 0.859243 2.23591 2.22874C0.863447 3.59918 0.0651938 5.44139 0.00381983 7.37995C-0.0575541 9.3185 0.622571 11.2075 1.9056 12.662C3.18862 14.1165 4.97798 15.0271 6.90905 15.2081C8.84011 15.3892 10.7675 14.8271 12.2985 13.6364L12.3395 13.6792L16.3802 17.7209C16.4687 17.8094 16.5737 17.8796 16.6894 17.9275C16.805 17.9753 16.9289 18 17.0541 18C17.1793 18 17.3032 17.9753 17.4188 17.9275C17.5345 17.8796 17.6395 17.8094 17.728 17.7209C17.8165 17.6324 17.8867 17.5273 17.9346 17.4117C17.9825 17.296 18.0072 17.1721 18.0072 17.0469C18.0072 16.9218 17.9825 16.7978 17.9346 16.6822C17.8867 16.5666 17.8165 16.4615 17.728 16.373L13.6864 12.3323C13.6725 12.3186 13.6582 12.3053 13.6435 12.2923ZM11.6661 3.57658C12.2039 4.1057 12.6316 4.73606 12.9246 5.43131C13.2175 6.12655 13.3699 6.87293 13.373 7.62737C13.3761 8.38182 13.2297 9.12941 12.9425 9.82702C12.6552 10.5246 12.2326 11.1585 11.6991 11.6919C11.1656 12.2254 10.5318 12.648 9.83419 12.9353C9.13658 13.2226 8.38899 13.3689 7.63454 13.3658C6.8801 13.3628 6.13373 13.2104 5.43848 12.9174C4.74323 12.6244 4.11287 12.1967 3.58375 11.6589C2.52636 10.5841 1.93648 9.13508 1.94262 7.62737C1.94876 6.11967 2.55042 4.67547 3.61653 3.60936C4.68265 2.54325 6.12684 1.94159 7.63454 1.93545C9.14225 1.92931 10.5913 2.51919 11.6661 3.57658Z"
                                    fill="#9FADC4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="filter-box">
                    <h5>Nama Fasilitator</h5>
                    <div class="search-container">
                        <input class="searchbox" type="text" id="searchFasilitator" name="searchFasilitator"
                            placeholder="Cari Fasilitator" value="{{ $searchFasilitator ?? '' }}">
                        <button class="search-button" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M13.6435 12.2923C14.8313 10.761 15.3911 8.83464 15.209 6.9052C15.0269 4.97576 14.1166 3.18816 12.6633 1.90607C11.21 0.62398 9.32284 -0.0562918 7.38576 0.00364974C5.44867 0.0635913 3.60718 0.859243 2.23591 2.22874C0.863447 3.59918 0.0651938 5.44139 0.00381983 7.37995C-0.0575541 9.3185 0.622571 11.2075 1.9056 12.662C3.18862 14.1165 4.97798 15.0271 6.90905 15.2081C8.84011 15.3892 10.7675 14.8271 12.2985 13.6364L12.3395 13.6792L16.3802 17.7209C16.4687 17.8094 16.5737 17.8796 16.6894 17.9275C16.805 17.9753 16.9289 18 17.0541 18C17.1793 18 17.3032 17.9753 17.4188 17.9275C17.5345 17.8796 17.6395 17.8094 17.728 17.7209C17.8165 17.6324 17.8867 17.5273 17.9346 17.4117C17.9825 17.296 18.0072 17.1721 18.0072 17.0469C18.0072 16.9218 17.9825 16.7978 17.9346 16.6822C17.8867 16.5666 17.8165 16.4615 17.728 16.373L13.6864 12.3323C13.6725 12.3186 13.6582 12.3053 13.6435 12.2923ZM11.6661 3.57658C12.2039 4.1057 12.6316 4.73606 12.9246 5.43131C13.2175 6.12655 13.3699 6.87293 13.373 7.62737C13.3761 8.38182 13.2297 9.12941 12.9425 9.82702C12.6552 10.5246 12.2326 11.1585 11.6991 11.6919C11.1656 12.2254 10.5318 12.648 9.83419 12.9353C9.13658 13.2226 8.38899 13.3689 7.63454 13.3658C6.8801 13.3628 6.13373 13.2104 5.43848 12.9174C4.74323 12.6244 4.11287 12.1967 3.58375 11.6589C2.52636 10.5841 1.93648 9.13508 1.94262 7.62737C1.94876 6.11967 2.55042 4.67547 3.61653 3.60936C4.68265 2.54325 6.12684 1.94159 7.63454 1.93545C9.14225 1.92931 10.5913 2.51919 11.6661 3.57658Z"
                                    fill="#9FADC4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <button type="submit" class="btn-outline">Reset</button>
                    <button type="submit" class="btn-fill">Filter</button>
                </div>
            </form>


            <p>Urutkan</p>
            <form action="{{ route('activities.index') }}" method="GET">
                <div class="filter-box">
                    <h5>Urutkan Berdasarkan</h5>
                    {{-- Dropdown --}}
                    <select id="sortBy" name="sortBy" class="searchbox">
                        <option value="" class="placeholder">Pilih</option>
                        <option value="dateClosest">Tanggal Terdekat</option>
                        <option value="dateFarthest">Tanggal Terjauh</option>
                        <option value="mostLikes">Like Terbanyak</option>
                        <option value="leastLikes">Like Terdikit</option>
                    </select>
                </div>

                <div class="row">
                    <button type="submit" class="btn-outline">Reset</button>
                    <button type="submit" class="btn-fill" name="sort" value="true">Filter</button>
                </div>
            </form>
        </div>
        <div class="activities-grid">


            @foreach ($activities as $a)
                <x-activity-card :activity="$a" />
            @endforeach
        </div>
    </div>
    <div class="activities-pagination">
        {{ $activities->links() }}
    </div>
@endsection
