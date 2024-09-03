@extends('layouts.app-admin')

@section('isi')
    <section class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h1>Page Admin</h1>
        <h1 id="text-halo">Halo, {{ @Auth::user()->name }}!</h1>
        <p>{{ @$role }}</p>

        <button id="btn-show" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Show Data
        </button>

        <table id="table-data" class="hidden">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>

        <div class="relative overflow-x-auto mt-12">
            <table id="example">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Updated At</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.tailwindcss.js"></script>
    <script>
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin.users.data') }}",
            order: [[1, 'desc']],
            layout: {
                topStart: 'pageLength',
                topEnd: {
                    features: [{
                        search: {

                        }
                    }]
                },
                bottomStart: 'info',
                bottomEnd: 'paging'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'updated_at', name: 'updated_at', orderable: true, searchable: true, visible: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action' },
            ]
        });
    </script>

    <script>
        $('#btn-show').on('click', function() {
            $('#table-data').removeClass('hidden');
            $('#btn-show').text('Reload Data');

            $.ajax({
                url: "{{ route('admin.users.data') }}",
                type: "GET",
                dataType: "JSON",
                data: {
                    tipe: 'plain'
                },
                success: function(response) {
                    const data = response.data;

                    if (response.status == 'success') {
                        $('#table-body').empty();

                        for (let i = 0; i < data.length; i++) {
                            const user = data[i];

                            $('#table-body').append(`
                                <tr>
                                    <td>${ user.name }</td>
                                    <td>${ user.email }</td>
                                </tr>
                            `);
                        }
                    }
                }
            });
        });

    </script>
@endpush
