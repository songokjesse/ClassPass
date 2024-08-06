<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$timetable->course->course_code}}: {{$timetable->course->course_name}} | {{ __('Attendance QR Code') }}
</h2>
</x-slot>

<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        {{--    <x-application-logo class="block h-12 w-auto" />--}}

        <div class="flex items-center justify-between ">
            <h1 class="mt-2 text-2xl font-medium text-gray-900">
                {{$timetable->course->course_code}}: {{$timetable->course->course_name}}
            </h1>
            <x-button>Print</x-button>
        </div>
        <h3>Location:  {{$timetable->location_name}}</h3>
        <h3>Date: {{$timetable->date}}</h3>
        <h3>Time: {{$timetable->start_time}}</h3>
        <div class="flex items-center justify-center">
        <img src="{{url($qrCode) }}" alt="Attendance QR Code">
        </div>

    </div>
</div>
</div>
</div>
</x-app-layout>
