@extends('layouts.app')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-gray-700 uppercase font-bold">Danh sách bài làm</h2>
        </div>
    </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-3/12 px-4 py-3">ID</div>
                <div class="w-3/12 px-4 py-3">Họ tên sinh viên</div>
                <div class="w-3/12 px-4 py-3">Bài làm</div>
            </div>
            @foreach ($result as $res)
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $res->id }}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{$res->name}}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">
                        <a href="{{ route('homework.downloadsolution',$res->filename) }}">{{$res->filename}}</a>
                    </div>
                </div>
            @endforeach
        </div>
@endsection