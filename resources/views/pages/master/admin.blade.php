@extends('layouts.app-admin')

@section('isi')
    <section class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h1>Page Admin</h1>
        <h1 id="text-halo">Halo, {{ @Auth::user()->name }}!</h1>
        <p>{{ @$role }}</p>
    </section>
@endsection
