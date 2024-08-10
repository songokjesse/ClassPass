<x-guest-layout>
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    {{--<x-application-logo class="block h-12 w-auto" />--}}

                    <div>
                        <h1 class="flex items-center justify-center mt-2  mb-3 text-2xl font-medium text-gray-900">
                        {{$timetable->course->course_code}} : {{$timetable->course->course_name}}
                        </h1>
                        <h1 class="flex items-center justify-center mt-2  mb-3 text-2xl font-medium text-gray-900">
                            Enter Admission Number to Record Attendance
                        </h1>
                    </div>

                    <hr/>
                    <form class="form mt-6" action="{{route('timetable.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="timetable_id" value="{{$timetable->id}}">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Student Admission Number</label>
                            <input type="text" name="admission_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Student Admission Number" >
                            @error('admission_no') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <x-button type="submit">
                                Submit Attendance
                            </x-button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
