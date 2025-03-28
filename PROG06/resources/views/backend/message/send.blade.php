@extends('layouts.app')

@section('content')
<div class="table w-full mt-8 bg-white rounded">
    <form action="{{ route('message.send') }}" method="POST" class="w-full max-w-xl px-6 py-12" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $rid }}">
        
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4">
                    De lai loi nhan
                </label>
            </div>
            <div class="md:w-2/3">
                <input name="msg" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" type="text">
                @error('msg')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button class="w-full shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Gui tin nhan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection