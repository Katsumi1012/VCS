@extends('layouts.app')

@section('content')
<div class="flex flex-col">
    <div class="dashboard-header flex flex-col md:flex-row justify-between items-center mb-6">
        <h2 class="text-gray-700 text-2xl font-bold">Dashboard</h2>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('profile.index') }}" class="flex items-center py-2 px-4 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <span class="mr-1.5">
                    <i class="fas fa-user"></i>
                </span>
                <span class="ml-2 text-xs font-semibold">Profile</span>
            </a>
        </div>
    </div>

    @role('Teacher')
        @include('dashboard.teacher')
    @endrole
<!--
    @role('Parent')
        @include('dashboard.parents')
    @endrole

    @role('Teacher')
        @include('dashboard.teacher')
    @endrole
-->
    @role('Student')
        @include('dashboard.student')
    @endrole

</div>

@endsection
