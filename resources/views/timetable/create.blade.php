<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{$course->course_code}} : {{$course->course_name}}  {{ __('Lesson Slots') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    {{--<x-application-logo class="block h-12 w-auto" />--}}

                    <div class="flex justify-between">
                        <h1 class="mt-2 text-2xl font-medium text-gray-900">
                            My Courses
                        </h1>
                        <a href="{{route('timetable.index', $course->id)}}"><x-button>Back to Course</x-button></a>
                    </div>

                    <div class=" flex items-center justify-center text-xl font-medium text-gray-900 mt-3 mb-3">
                        Add Lesson Time
                    </div>
                    <hr/>
                    <form class="form mt-6" action="{{route('timetable.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{$course->id}}">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Lecture Hall Name:</label>
                            <input type="text" name="location_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Lecture Hall Name" >
                            @error('location_name') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                            <input type="date" min="{{\Carbon\Carbon::now()->toDateString()}}" name="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" placeholder="Enter Lesson Date" >
                            @error('date') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput3" class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                            <input type="time" name="start_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput3" placeholder="Enter Lesson Start Time" >
                            @error('start_time') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput3" class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                            <input type="time" name="end_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput4" placeholder="Enter Lesson End Time" >
                            @error('end_time') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

                        <div class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <x-button type="submit">
                                Save
                            </x-button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
