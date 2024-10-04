<div class="single-slider-boxed text-center owl-no-dots owl-carousel">
    <div class="card rounded-l shadow-l" data-card-height="320">
        <div class="card-bottom">
            <h1 class="font-24 font-700">

                @if (session('lang') === 'id')
                {{ 'Kenali Binge Eating Disorder' }}
                @else
                {{ $translate->translate('Binge Eating Disorder') }}
                @endif
            </h1>
            <p class="boxed-text-xl">
                @if (session('lang') === 'id')
                    {{ 'Pelajari tentang Binge Eating Disorder, bagaimana mengenali gejalanya, dan cara mengatasinya dengan bijak.' }}
                @else
                    {{ $translate->translate('Pelajari tentang Binge Eating Disorder, bagaimana mengenali gejalanya, dan cara mengatasinya dengan bijak.') }}
                @endif
            </p>
        </div>
        <div class="card-overlay bg-gradient-fade"></div>
        <div class="card-bg owl-lazy" data-src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSY-kEcR4MozEQYAJ15m3FGY-t8c1tpJpqSdg&s"></div>
    </div>
    <div class="card rounded-l shadow-l" data-card-height="320">
        <div class="card-bottom">
            <h1 class="font-24 font-700">
                @if (session('lang') === 'id')
                    {{ 'Kisah Pemulihan' }}
                @else
                    {{ $translate->translate('Kisah Pemulihan') }}
                @endif
            </h1>
            <p class="boxed-text-xl">
                @if (session('lang') === 'id')
                    {{ 'Baca cerita inspiratif dari mereka yang berhasil mengatasi Binge Eating Disorder dan menemukan keseimbangan hidup.' }}
                @else
                    {{ $translate->translate('Baca cerita inspiratif dari mereka yang berhasil mengatasi Binge Eating Disorder dan menemukan keseimbangan hidup.') }}
                @endif
            </p>
        </div>
        <div class="card-overlay bg-gradient-fade"></div>
        <div class="card-bg owl-lazy" data-src="https://res.cloudinary.com/dk0z4ums3/image/upload/v1614664558/attached_image/beragam-manfaat-olahraga.jpg"></div>
    </div>
    <div class="card rounded-l shadow-l" data-card-height="320">
        <div class="card-bottom">
            <h1 class="font-24 font-700">
                @if (session('lang') === 'id')
                    {{ 'Dukungan dan Bantuan' }}
                @else
                    {{ $translate->translate('Dukungan dan Bantuan') }}
                @endif
            </h1>
            <p class="boxed-text-xl">
                @if (session('lang') === 'id')
                    {{ 'Temukan sumber daya dan dukungan yang tersedia untuk membantu Anda atau orang yang Anda cintai.' }}
                @else
                    {{ $translate->translate('Temukan sumber daya dan dukungan yang tersedia untuk membantu Anda atau orang yang Anda cintai.') }}
                @endif
            </p>
        </div>
        <div class="card-overlay bg-gradient-fade"></div>
        <div class="card-bg owl-lazy" data-src="https://storage.googleapis.com/ekrutassets/blogs/images/000/004/856/original/Kenali_apa_saja_fungsi_FAQ_dan_tips_membuat_FAQ_yang_efektif.jpg"></div>
    </div>
</div>
