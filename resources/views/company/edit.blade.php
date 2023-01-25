@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Company</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('company.update',$company->id) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <label for="name" class="col-md-2 col-form-label text-md-end">Company Name</label>

                                <div class="col-md-8">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ $company->name }}" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label for="email"
                                       class="col-md-2 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ $company->email }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="image"
                                       class="col-md-2 col-form-label text-md-end">Logo</label>

                                <div class="col-md-8">
                                    <input id="image" type="file"
                                           class="form-control @error('image') is-invalid @enderror"
                                           name="image" value="{{ $company->image }}" required autofocus>
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
                                        Update
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
                center: [{{$company->coordinate_x}},{{$company->coordinate_y}}],
                zoom: 11
            },
                {
                balloonMaxWidth: 200,
                searchControlProvider: 'yandex#search'
            });
            myMap.geoObjects
                .add(new ymaps.Placemark([{{$company->coordinate_x}},{{$company->coordinate_y}}], {
                    balloonContent: '<strong>Old Address of company</strong>'
                }, {
                    preset: 'islands#icon',
                    iconColor: '#0095b6'
                }))

            myMap.events.add('click', function (e) {
                var coords = e.get('coords');
               myMap.geoObjects
                    .add(new ymaps.Placemark([coords[0],coords[1]],
                        {
                            balloonContent: '<strong>New Address</strong>'
                        },{
                            preset: 'islands#icon',
                            iconColor: '#FF0000'
                        }))
                myMap.geoObjects.events.add('click', function (e) {
                    // Получение ссылки на дочерний объект, на котором произошло событие.
                    var object = e.get('target');
                    myMap.geoObjects.remove(object)
                });
                if (!myMap.balloon.isOpen()) {
                    document.getElementById('coordinate_y').setAttribute('value',coords[1])
                    document.getElementById('coordinate_x').setAttribute('value',coords[0])

                }
                else {
                    myMap.balloon.close();
                }
            });

            // Скрываем хинт при открытии балуна.
            myMap.events.add('balloonopen', function (e) {
                myMap.hint.close();
            });
        }
    </script>
@endpush
