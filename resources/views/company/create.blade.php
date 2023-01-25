@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Employee</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <label for="name" class="col-md-2 col-form-label text-md-end">Company Name</label>

                                <div class="col-md-8">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="email"
                                       class="col-md-2 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="image"
                                       class="col-md-2 col-form-label text-md-end">Logo</label>

                                <div class="col-md-8">
                                    <input id="image" type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           name="image" value="{{ old('image') }}" autofocus required>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="map"
                                       class="col-md-2 col-form-label text-md-end">Address</label>

                                <div class="col-md-8">
                                    <input id="coordinate_y" type="hidden" name="coordinate_y" value="{{ old('coordinate_y') }}" autofocus>
                                    <input id="coordinate_x" name="coordinate_x" type="hidden" value="{{ old('coordinate_x') }}" autofocus>
                                    <div id="map" style="width: 600px; height: 400px"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap;

        function init () {
            myMap = new ymaps.Map("map", {
                center: [55.718087132208616, 37.629912589264556], // Углич
                zoom: 11
            }, {
                balloonMaxWidth: 200,
                searchControlProvider: 'yandex#search'
            });

            // Обработка события, возникающего при щелчке
            // левой кнопкой мыши в любой точке карты.
            // При возникновении такого события откроем балун.
            myMap.events.add('click', function (e) {
                // console.log('salom')
                if (!myMap.balloon.isOpen()) {
                    var coords = e.get('coords');
                    document.getElementById('coordinate_y').setAttribute('value',coords[1])
                    document.getElementById('coordinate_x').setAttribute('value',coords[0])
                    myMap.balloon.open(coords, {
                        contentHeader:'Ваше адресс!',
                        contentBody:'<p>Вы уверны что ваше адрес правилный!.</p>' +
                            '<p>Координаты щелчка: ' + [
                                coords[0],
                                coords[1],
                            ].join(', ') + '</p>',

                        contentFooter:'<sup>если да тогда оставте так, если нет вы можете изменит</sup>'
                    });
                }
                else {
                    myMap.balloon.close();
                }
            });

            // Обработка события, возникающего при щелчке
            // правой кнопки мыши в любой точке карты.
            // При возникновении такого события покажем всплывающую подсказку
            // в точке щелчка.
            myMap.events.add('contextmenu', function (e) {
                myMap.hint.open(e.get('coords'), 'Кто-то щелкнул правой кнопкой');
            });

            // Скрываем хинт при открытии балуна.
            myMap.events.add('balloonopen', function (e) {
                myMap.hint.close();
            });
        }
    </script>
@endpush
