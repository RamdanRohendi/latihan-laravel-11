@extends('layouts.app-admin')

@section('isi')
    <section class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex align-middle justify-between">
            <h1 class="mb-0 font-bold align-middle">List Users</h1>

            <a href="{{ route('admin.users.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 focus:outline-none">
                Tambah Data
            </a>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2 p-5">
            <table id="example" class="min-w-full divide-y divide-x divide-gray-200 border">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">No</th>
                        <th class="border py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Updated At</th>
                        <th class="border py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                        <th class="border py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Email</th>
                        <th class="border py-3 text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
            </table>
            <tbody class="bg-white divide-y divide-gray-200"></tbody>
            {{-- <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               {{ $loop->iteration }}
                            </th>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="font-medium text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button
                                        type="submit"
                                        class="font-medium text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </section>
@endsection

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            const tableData = $('#example').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.users.data') }}",
                order: [[1, 'desc']],
                initComplete: function() {
                    addCostumStyle();
                },
                drawCallback: function() {
                    addCostumStyle();
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'updated_at', name: 'updated_at', orderable: true, searchable: true, visible: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action' },
                ],
                columnDefs: [
                    {
                        targets: 0,
                        className: 'text-center border',
                    },
                    {
                        targets: [1, 2, 3, 4],
                        className: 'text-left px-2 border',
                    },
                ]
            });

            $(document).on('click', '.btn-delete', function() {
                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Anda yakin ingin menghapus data ini?',
                    text: 'Data yang di hapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'DELETE',
                            data: form.serialize(),
                            success: function(result) {
                                console.log(result);

                                if (result.status == 'success') {
                                    tableData.ajax.reload();

                                    Swal.fire(
                                        'Berhasil!',
                                        result.message,
                                        'success'
                                    );
                                }
                            }
                        })
                    }
                }).catch((error) => {
                    console.log(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                })
            });

            $(window).on('resize', function() {
                setTimeout(function() {
                    addCostumStyle();
                }, 300);
            });

            tableData.on('responsive-resize', function (e, datatable, columns) {
            });
        });

        function addCostumStyle() {
            $('.dt-layout-row').each(function(index, element) {
                const row = $(this);

                if (!row.hasClass('dt-layout-table')) {
                    row.addClass('flex justify-between');
                }
            })

            $('.dt-layout-table').addClass('p-3');

            $('#dt-search-0').addClass('ms-3');
            $('#example_wrapper').addClass('m-1');

            $('.dt-paging>nav').addClass('inline-flex rounded-md shadow-sm');
            $('.dt-paging>nav').attr('role', 'group');
            $('.dt-paging>nav>span').addClass('px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200');
            $('.dt-paging-button').each(function(index, element) {
                const button = $(this);
                const buttonGroupIndex = button.attr('data-dt-idx');
                const isDisabled = button.attr('aria-disabled') == 'true';
                const isActive = button.attr('aria-current') == 'page';

                if (buttonGroupIndex == 'first') {
                    if (isDisabled) {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 rounded-s-lg');
                        button.attr('disabled', 'disabled');
                    } else {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700');
                    }
                } else if (buttonGroupIndex == 'last') {
                    if (isDisabled) {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200 rounded-e-lg');
                        button.attr('disabled', 'disabled');
                    } else {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700');
                    }
                } else {
                    if (isActive) {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-900 bg-gray-200 border border-gray-200');
                    } else if (isDisabled) {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-300 bg-white border border-gray-200');
                        button.attr('disabled', 'disabled');
                    } else {
                        button.addClass('px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700');
                    }
                }
            });
        }
    </script>
@endpush
