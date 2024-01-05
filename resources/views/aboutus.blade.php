@extends('layout.index')

@section('css')
    {{-- @include('layout.useBootstrap') --}}
    <link rel="stylesheet" href="{{ asset('/css/aboutus.css') }}" />
@endsection

@section('content')
    <div class="aboutus-body">
        <div class="au-hero">
            <h1>Inisiatif Pertama Mahasiswa
                <br>
                untuk menghubungkan
                <br>
                Sukarelawan dan Fasilitator
                <br>
                kebersihan Sungai Ciliwung
            </h1>
            <img src="{{ asset('images/AboutUs/bg_1.png') }}" alt="">
        </div>
        <div class="lb au-content">
            <h1>Latar Belakang</h1>
            <div class="lb-body">
                <p>
                    <span class="highlighted">Sungai Ciliwung</span>
                    yang membentang sepanjang 120 km, menjadi penyumbang limbah plastik terbanyak ke lautan
                    dengan volume mencapai 1.000 ton per tahun, menimbulkan dampak serius terhadap kesehatan lingkungan dan
                    ekosistem. Untuk mengatasi masalah ini, perlu ditingkatkan kesadaran dan partisipasi masyarakat dalam
                    kegiatan pembersihan sungai. Website ini telah dikembangkan untuk memfasilitasi perencanaan,
                    pengelolaan,
                    dan penyelenggaraan acara kerja bakti pembersihan sungai, serta memberikan insentif berupa penukaran
                    poin
                    menjadi hadiah bagi para Sukarelawan. Fokus utamanya adalah pada perancangan sistem yang menyediakan
                    informasi dan memudahkan koordinasi antara Fasilitator dan Sukarelawan, memastikan kelancaran
                    pelaksanaan
                    kegiatan agar nantinya Sukarelawan dapat memperoleh poin sebagai bentuk apresiasi atas kontribusi mereka
                    dalam acara kerja bakti.
                </p>
                <div class="img-col">
                    <img src="{{ asset('images/AboutUs/sungai_1.png') }}" alt="">
                    <img src="{{ asset('images/AboutUs/sungai_2.png') }}" alt="">
                    <img src="{{ asset('images/AboutUs/sungai_3.png') }}" alt="">
                </div>
            </div>
            <div class="lb-bg">
                <img src="{{ asset('images/AboutUs/bg_2.png') }}" alt="">
            </div>
        </div>
        <div class="au-content tujuan">
            <h1>Tujuan</h1>
            <div class="tujuan-body">
                <div class="left">
                    <div class="list">
                        <div class="index">1</div>
                        <p>Mengurangi jumlah limbah sungai.</p>
                    </div>
                    <div class="list">
                        <div class="index">2</div>
                        <p>Meningkatkan kepedulian akan kebersihan sungai.</p>
                    </div>
                    <div class="list">
                        <div class="index">3</div>
                        <p>Meningkatkan motivasi gotong royong.</p>
                    </div>
                    <div class="list">
                        <div class="index">4</div>
                        <p>Membangun komunitas sukarelawan dan fasilitator.</p>
                    </div>
                    <div class="list">
                        <div class="index">5</div>
                        <p>Melestarikan budaya gotong royong Indonesia.</p>
                    </div>
                </div>
                <div class="right">
                    <img src="{{ asset('images/AboutUs/tujuan.png') }}" alt="">

                </div>
            </div>
        </div>
        <div class="au-content team">
            <h1>Tim Riverse</h1>
            <div class="bg-img">
                <img src="{{ asset('images/AboutUs/bg_3.png') }}" alt="">

            </div>
            <div class="members">
                <div class="member">
                    <img src="{{ asset('images/AboutUs/kevin.png') }}" alt="">
                    <div class="nim">2440038490</div>
                    <div class="name">Kevin <br> Bryan</div>
                </div>
                <div class="member">
                    <img src="{{ asset('images/AboutUs/elliot.png') }}" alt="">
                    <div class="nim">2440046984</div>
                    <div class="name">Elliot <br> Lie Arifin</div>
                </div>
                <div class="member">
                    <img src="{{ asset('images/AboutUs/cindy.png') }}" alt="">
                    <div class="nim">2440055351</div>
                    <div class="name">Cindy Amanda <br> Onggirawan</div>
                </div>
            </div>
        </div>
    </div>
@endsection
