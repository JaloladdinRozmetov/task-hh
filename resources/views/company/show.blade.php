@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <p>Name of company:{{$company->name}}</p>
            <p>Email of company:{{$company->email}}</p>
            <p>Logo of company:</p><img src="/storage/image/{{$company->image}}" style="height: 100px;width: 100px" alt="">
            <p>Address of company:</p>
            <div id="map" style="width: 600px; height: 400px"></div>
            <h2>Employees of company</h2>
            <div class="col-12 table-responsive">
                <table class="table table-bordered user_datatable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($company->employees as $employee)
                    <tr>
                        <td>{{$employee->id}}</td>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->email}}</td>
                        <td>{{$employee->phone_number}}</td>
                        <td>{{$employee->company->name}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<ваш API-ключ>" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);

        function init() {
            var myMap = new ymaps.Map("map", {
                    center: [{{$company->coordinate_x}},{{$company->coordinate_y}}],
                    zoom: 10
                }, {
                    searchControlProvider: 'yandex#search'
                }),

                // Создаем геообъект с типом геометрии "Точка".
                myGeoObject = new ymaps.GeoObject({
                    // Описание геометрии.
                    geometry: {
                        type: "Point",
                        coordinates: [{{$company->coordinate_x}},{{$company->coordinate_y}}]
                    },
                }),
                myPieChart = new ymaps.Placemark([
                    {{$company->coordinate_x}},{{$company->coordinate_y}}
                ]);

            myMap.geoObjects
                .add(new ymaps.Placemark([{{$company->coordinate_x}},{{$company->coordinate_y}}], {
                    balloonContent: '<strong>Address of company</strong>'
                }, {
                    preset: 'islands#icon',
                    iconColor: '#0095b6'
                }))
        }
    </script>
@endpush
