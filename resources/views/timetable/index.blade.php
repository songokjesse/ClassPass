<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$course->course_code}} : {{$course->course_name}} {{ __('Timetable') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    {{--    <x-application-logo class="block h-12 w-auto" />--}}

                    <div class="flex justify-between">
                        <h1 class="mt-2 text-2xl font-medium text-gray-900">
                        Timetable
                        </h1>
                        <a href="{{route('timetable.create', $course->id)}}"><x-button>Add Lesson</x-button></a>
                    </div>
                    <div class="overflow-x-auto ">
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">#</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Date</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Location</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">Start Time</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">End Time</th>
                                <th class="px-6 py-3 bg-gray-50 text-left">QR Code/Attendance</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($timetables as $timetable)
                                <tr>
                                    <td class=" sm:table-cell px-6 py-4 whitespace-nowrap">{{$loop->iteration}}</td>
                                    <td class="sm:table-cell px-6 py-4 whitespace-nowrap">{{$timetable->date}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$timetable->location_name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$timetable->start_time}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$timetable->end_time}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><a href="#"><x-button>Print QR</x-button></a><a href="{{route('attendance.index', $timetable->id)}}"><x-button>View Attendance</x-button></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
