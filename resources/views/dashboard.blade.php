<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    {{--    <x-application-logo class="block h-12 w-auto" />--}}

                    <div class="flex justify-between">
                        <h1 class="mt-2 text-2xl font-medium text-gray-900">
                            My Courses
                        </h1>
                        <a href="{{route('courses.create')}}"><x-button>Add Course</x-button></a>
                    </div>
                        @if(count($courses) === 0)
                                <div class="flex items-center justify-center" >
                                    <h2 class="mt-2 text-2xl font-medium text-gray-900">No courses currently added</h2>
                                </div>
                        @else
                        <div class="container mx-auto">
                            <div class="overflow-x-auto ">
                                <table class="min-w-full divide-y divide-gray-200 mt-2">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left">#</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left">Course Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left">Course Code</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left">Attendance</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                    @foreach($courses as $course)
                                                <tr>
                                                    <td class=" sm:table-cell px-6 py-4 whitespace-nowrap">{{$loop->iteration}}</td>
                                                    <td class="sm:table-cell px-6 py-4 whitespace-nowrap">{{$course->course_name}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{$course->course_code}}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap"><a href="{{route('timetable.index', $course->id)}}"><x-button>View</x-button></a></td>
                                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
