@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('company.create')}}" class="btn btn-success">Create</a>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered user_datatable" id="myTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>image</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(function () {
            var table = $('.user_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('company.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'image', name: 'image',
                        render: function( data, type, full, meta ) {
                            return "<img src=\"/storage/image/" + data + "\" height=\"50\"/>";
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endpush
