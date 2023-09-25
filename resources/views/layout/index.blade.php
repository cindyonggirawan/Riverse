<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Riverse</title>
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('/css/global.css') }}"/>
  @yield('css')
</head>
<body>

  {{-- Nav bar --}}
  <div class="custom-nav">
    <div class="nav-row">
      <a href="/">
        <img src="{{asset("images/logo.png")}}" alt="Riverse Logo">
      </a>
      <a class="nav-link {{Request::is('activity') ? 'selected underlined': ''}}" aria-current="page" href="/activity">Aktivitas</a>
      <a class="nav-link {{Request::is('/leaderboard') ? 'selected underlined': ''}}" aria-current="page" href="/leaderboard">Leaderboard</a>
      <a class="nav-link {{Request::is('/benefit') ? 'selected underlined': ''}}" aria-current="page" href="/benefit">Keuntungan</a>
      <a class="nav-link {{Request::is('/tutorial') ? 'selected underlined': ''}}" aria-current="page" href="/tutorial">Cara Kerja</a>
      <a class="nav-link {{Request::is('/aboutus') ? 'selected underlined': ''}}" aria-current="page" href="/aboutus">Tentang Kami</a>
    </div>

    <div class="nav-row">
      @if(null != auth()->user())
      {{-- LOGOUT --}}
        <h5>
            Hello,
            @if(auth()->user()->role_id == 0)
                Sukarelawan {{ $sukarelawan->name }}
            @elseif (auth()->user()->role_id == 1)
                Fasilitator {{ $fasilitator->name }}
            @endif
        </h5>

        @if(auth()->user()->role_id == 0)
            <img class="custom-test-profile-image shadow-4-strong" src={{ asset('storage/' . $sukarelawan->picture) }} alt="sukarelawan image">
        @elseif (auth()->user()->role_id == 1)
            <img class="custom-test-profile-image shadow-4-strong" src={{ asset('storage/' . $fasilitator->picture) }} alt="fasilitator image">
        @endif

        <form action="/logout" method="post">
            @csrf
            <button class="w-100 btn btn-sm btn-primary" type="submit">Logout</button>
        </form>

      {{-- redirect to Register as Sukarelawan --}}
      @else
      {{-- LOGIN --}}
      <a class="nav-link selected" href="/login">Login</a>
      <a class="rect-btn-outline" {{Request::is('register') ? 'active': ''}}" href="/register">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="15" viewBox="0 0 17 15" fill="none">
            <path d="M7.055 3.91667C6.97626 3.99294 6.91374 4.08377 6.87107 4.1839C6.8284 4.28404 6.80643 4.39148 6.80643 4.5C6.80643 4.60852 6.8284 4.71596 6.87107 4.8161C6.91374 4.91623 6.97626 5.00706 7.055 5.08333L8.67 6.66667H0.85C0.3825 6.66667 0 7.04167 0 7.5C0 7.95833 0.3825 8.33333 0.85 8.33333H8.67L7.055 9.91667C6.97626 9.99294 6.91374 10.0838 6.87107 10.1839C6.8284 10.284 6.80643 10.3915 6.80643 10.5C6.80643 10.6085 6.8284 10.716 6.87107 10.8161C6.91374 10.9162 6.97626 11.0071 7.055 11.0833C7.3865 11.4083 7.9135 11.4083 8.245 11.0833L11.2965 8.09167C11.3753 8.01457 11.4378 7.923 11.4805 7.82219C11.5231 7.72138 11.5451 7.61331 11.5451 7.50417C11.5451 7.39503 11.5231 7.28696 11.4805 7.18615C11.4378 7.08534 11.3753 6.99376 11.2965 6.91667L8.245 3.91667C8.16721 3.83947 8.07455 3.77817 7.97242 3.73634C7.87028 3.69451 7.76069 3.67297 7.65 3.67297C7.53931 3.67297 7.42972 3.69451 7.32758 3.73634C7.22545 3.77817 7.13279 3.83947 7.055 3.91667ZM15.3 13.3333H9.35C8.8825 13.3333 8.5 13.7083 8.5 14.1667C8.5 14.625 8.8825 15 9.35 15H15.3C16.235 15 17 14.25 17 13.3333V1.66667C17 0.75 16.235 0 15.3 0H9.35C8.8825 0 8.5 0.375 8.5 0.833333C8.5 1.29167 8.8825 1.66667 9.35 1.66667H15.3V13.3333Z" fill="#19B2E2"/>
          </svg>
          <p>
            Masuk
          </p>
      </a>
      @endif
    </div>
  </div>

  {{-- Content --}}
  <div class="page-body">
    @yield('content')
  </div>

  {{-- Footer --}}
  @include('layout.components.footer')

  @stack('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 100) {
                $('.custom-nav').addClass('scrolled');
            } else {
                $('.custom-nav').removeClass('scrolled');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>
